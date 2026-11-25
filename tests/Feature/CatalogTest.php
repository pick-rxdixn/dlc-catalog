<?php

namespace Tests\Feature;

use App\Models\Game;
use App\Models\Category;
use App\Models\Dlc;
use Database\Seeders\CatalogSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CatalogTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->seed(CatalogSeeder::class);
    }

    // Получение списка игр
    public function test_can_get_games(): void
    {
        $this->getJson('/api/games')
            ->assertStatus(200)
            ->assertJsonCount(3);
    }

    // Получение списка категорий
    public function test_can_get_categories(): void
    {
        $this->getJson('/api/categories')
            ->assertStatus(200)
            ->assertJsonCount(3);
    }

    // Получение каталога дополнений
    public function test_can_get_dlcs(): void
    {
        $this->getJson('/api/dlcs')
            ->assertStatus(200)
            ->assertJsonCount(9);
    }

    // Получение конкретного дополнения
    public function test_can_get_single_dlc(): void
    {
        $dlc = Dlc::firstOrFail();

        $this->getJson('/api/dlcs/' . $dlc->id)
            ->assertStatus(200)
            ->assertJsonPath('title', $dlc->title);
    }

    // Фильтрация по игре
    public function test_can_filter_dlcs_by_game(): void
    {
        $game = Game::where('title', 'Skyrim')->firstOrFail();

        $this->getJson('/api/dlcs?game_id=' . $game->id)
            ->assertStatus(200)
            ->assertJsonCount(3)
            ->assertJsonPath('0.game_id', $game->id);
    }

    // Фильтрация по категории
    public function test_can_filter_dlcs_by_category(): void
    {
        $category = Category::where(
            'name', 'Сюжетное'
        )->firstOrFail();

        $this->getJson('/api/dlcs?category_id=' . $category->id)
            ->assertStatus(200)
            ->assertJsonCount(6)
            ->assertJsonPath('0.category_id', $category->id);
    }

    // Поиск дополнения по названию
    public function test_can_search_dlcs(): void
    {
        $this->getJson('/api/dlcs?search=blood')
            ->assertStatus(200)
            ->assertJsonCount(1)
            ->assertJsonPath('0.title', 'Blood and Wine');
    }

    // Запрос несуществующего дополнения
    public function test_missing_dlc_returns_not_found(): void
    {
        $this->getJson('/api/dlcs/999999')
            ->assertStatus(404);
    }

    // Проверка некорректного фильтра
    public function test_invalid_filter_is_rejected(): void
    {
        $this->getJson('/api/dlcs?game_id=999999')
            ->assertStatus(422)
            ->assertJsonValidationErrors('game_id');
    }
}
