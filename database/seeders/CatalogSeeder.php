<?php

namespace Database\Seeders;

use App\Models\Game;
use App\Models\Category;
use App\Models\Dlc;
use Illuminate\Database\Seeder;

class CatalogSeeder extends Seeder
{
    public function run(): void
    {
        // Категории дополнений
        $story = Category::firstOrCreate([
            'name' => 'Сюжетное',
        ]);

        $mode = Category::firstOrCreate([
            'name' => 'Игровой режим',
        ]);

        $content = Category::firstOrCreate([
            'name' => 'Игровой контент',
        ]);

        // Игры
        $witcher = Game::firstOrCreate([
            'title' => 'The Witcher 3',
        ], [
            'description' => 'Ролевая игра о ведьмаке Геральте.',
        ]);

        $skyrim = Game::firstOrCreate([
            'title' => 'Skyrim',
        ], [
            'description' => 'Ролевая игра в открытом мире Тамриэля.',
        ]);

        $fallout = Game::firstOrCreate([
            'title' => 'Fallout 4',
        ], [
            'description' => 'Ролевая игра в постапокалиптическом мире.',
        ]);

        // Дополнения
        $dlcs = [
            [
                $witcher, $story,
                'Hearts of Stone',
                'Новая история о загадочном Гюнтере о Диме.',
            ],
            [
                $witcher, $story,
                'Blood and Wine',
                'Приключение в княжестве Туссент.',
            ],
            [
                $witcher, $mode,
                'New Game +',
                'Повторное прохождение с сохранением прогресса персонажа.',
            ],
            [
                $skyrim, $story,
                'Dawnguard',
                'История противостояния вампиров и Стражи Рассвета.',
            ],
            [
                $skyrim, $story,
                'Dragonborn',
                'Путешествие на остров Солстхейм.',
            ],
            [
                $skyrim, $content,
                'Hearthfire',
                'Возможность строительства собственного дома.',
            ],
            [
                $fallout, $story,
                'Far Harbor',
                'Приключение на загадочном острове.',
            ],
            [
                $fallout, $story,
                'Nuka-World',
                'Исследование заброшенного парка развлечений.',
            ],
            [
                $fallout, $content,
                'Automatron',
                'Создание и модификация роботов.',
            ],
        ];

        foreach ($dlcs as [$game, $category, $title, $description]) {
            Dlc::firstOrCreate([
                'game_id' => $game->id,
                'title' => $title,
            ], [
                'category_id' => $category->id,
                'description' => $description,
            ]);
        }
    }
}