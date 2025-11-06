<?php

namespace Database\Seeders;

use App\Models\Section;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SectionSeeder extends Seeder
{
    public function run(): void
    {
        $sections = [
            [
                'title' => 'ОСНОВНЫЕ ПОНЯТИЯ ПРОГРАММНОЙ ИНЖЕНЕРИИ',
                'slug' => 'software-engineering-basics',
                'description' => 'Освоение программной инженерии начинается с понимания ее фундаментальных понятий.',
                'order' => 1
            ],
            [
                'title' => 'ВСЁ О ТРЕБОВАНИЯХ',
                'slug' => 'requirements',
                'description' => 'Подробное рассмотрение требований в разработке ПО.',
                'order' => 2
            ],
            [
                'title' => 'УПРАВЛЕНИЕ ПРОЕКТОМ',
                'slug' => 'project-management',
                'description' => 'Основы управления IT-проектами и командами.',
                'order' => 3
            ],
            [
                'title' => 'МЕТОДОЛОГИИ РАЗРАБОТКИ ПО',
                'slug' => 'development-methodologies',
                'description' => 'Обзор современных методологий разработки ПО.',
                'order' => 4
            ],
            [
                'title' => 'ПРИНЦИПЫ И ПРАКТИКИ РАЗРАБОТКИ',
                'slug' => 'development-principles',
                'description' => 'Ключевые принципы и практики разработки качественного ПО.',
                'order' => 5
            ]
        ];

        foreach ($sections as $section) {
            Section::create($section);
        }
    }
}