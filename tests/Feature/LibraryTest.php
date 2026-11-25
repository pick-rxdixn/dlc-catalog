<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Dlc;
use Database\Seeders\CatalogSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LibraryTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(CatalogSeeder::class);
    }

    // Успешное получение дополнения
    public function test_user_can_claim_dlc(): void
    {
        $user = User::factory()->create();
        $dlc = Dlc::firstOrFail();

        $this->actingAs($user)
            ->postJson('/api/dlcs/' . $dlc->id . '/claim')
            ->assertStatus(201);

        $this->assertDatabaseHas('user_dlcs', [
            'user_id' => $user->id,
            'dlc_id' => $dlc->id,
        ]);
    }

    // Запрет повторного получения дополнения
    public function test_user_cannot_claim_dlc_twice(): void
    {
        $user = User::factory()->create();
        $dlc = Dlc::firstOrFail();

        $url = '/api/dlcs/' . $dlc->id . '/claim';

        $this->actingAs($user)
            ->postJson($url)
            ->assertStatus(201);

        $this->postJson($url)
            ->assertStatus(409);

        $this->assertDatabaseCount('user_dlcs', 1);
    }

    // Получение DLC без авторизации
    public function test_guest_cannot_claim_dlc(): void
    {
        $dlc = Dlc::firstOrFail();

        $this->postJson('/api/dlcs/' . $dlc->id . '/claim')
            ->assertStatus(401);

        $this->assertDatabaseCount('user_dlcs', 0);
    }

    // Получение несуществующего дополнения
    public function test_user_cannot_claim_missing_dlc(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->postJson('/api/dlcs/999999/claim')
            ->assertStatus(404);
    }

    // Просмотр личной библиотеки
    public function test_user_can_view_library(): void
    {
        $user = User::factory()->create();
        $dlc = Dlc::firstOrFail();

        $user->dlcs()->attach($dlc->id);

        $this->actingAs($user)
            ->getJson('/api/library')
            ->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJsonPath('0.id', $dlc->id);
    }

    // Просмотр пустой библиотеки
    public function test_user_can_view_empty_library(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->getJson('/api/library')
            ->assertStatus(200)
            ->assertJsonCount(0);
    }

    // Проверка изоляции библиотек пользователей
    public function test_user_cannot_see_another_users_dlcs(): void
    {
        $firstUser = User::factory()->create();
        $secondUser = User::factory()->create();

        $dlc = Dlc::firstOrFail();

        $firstUser->dlcs()->attach($dlc->id);

        $this->actingAs($secondUser)
            ->getJson('/api/library')
            ->assertStatus(200)
            ->assertJsonCount(0);
    }

    // Просмотр библиотеки без авторизации
    public function test_guest_cannot_view_library(): void
    {
        $this->getJson('/api/library')
            ->assertStatus(401);
    }
}