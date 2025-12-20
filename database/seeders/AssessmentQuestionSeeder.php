<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Game;

class AssessmentQuestionSeeder extends Seeder
{
    public function run(): void
    {
        $questions = [
            [
                'title' => 'CPU Assessment',
                'description' => 'Identify the computer part shown in the image',
                'question' => 'What is this computer component?',
                'answer' => 'CPU',
                'type' => 'guess_part',
                'status' => 'active',
                'thumbnail' => 'games/cpu.jpg',
                'game_file' => 'games/cpu.jpg',
                'options' => json_encode(['CPU', 'GPU', 'RAM', 'Motherboard', 'Hard Drive', 'SSD', 'Power Supply', 'Cooling Fan'])
            ],
            [
                'title' => 'GPU Assessment',
                'description' => 'Identify the computer part shown in the image',
                'question' => 'What is this computer component?',
                'answer' => 'GPU',
                'type' => 'guess_part',
                'status' => 'active',
                'thumbnail' => 'games/gpu.jpg',
                'game_file' => 'games/gpu.jpg',
                'options' => json_encode(['CPU', 'GPU', 'RAM', 'Motherboard', 'Hard Drive', 'SSD', 'Power Supply', 'Cooling Fan'])
            ],
            [
                'title' => 'RAM Assessment',
                'description' => 'Identify the computer part shown in the image',
                'question' => 'What is this computer component?',
                'answer' => 'RAM',
                'type' => 'guess_part',
                'status' => 'active',
                'thumbnail' => 'games/ram.jpg',
                'game_file' => 'games/ram.jpg',
                'options' => json_encode(['CPU', 'GPU', 'RAM', 'Motherboard', 'Hard Drive', 'SSD', 'Power Supply', 'Cooling Fan'])
            ],
            [
                'title' => 'Motherboard Assessment',
                'description' => 'Identify the computer part shown in the image',
                'question' => 'What is this computer component?',
                'answer' => 'Motherboard',
                'type' => 'guess_part',
                'status' => 'active',
                'thumbnail' => 'games/motherboard.jpg',
                'game_file' => 'games/motherboard.jpg',
                'options' => json_encode(['CPU', 'GPU', 'RAM', 'Motherboard', 'Hard Drive', 'SSD', 'Power Supply', 'Cooling Fan'])
            ],
            [
                'title' => 'Hard Drive Assessment',
                'description' => 'Identify the computer part shown in the image',
                'question' => 'What is this computer component?',
                'answer' => 'Hard Drive',
                'type' => 'guess_part',
                'status' => 'active',
                'thumbnail' => 'games/hard-drive.jpg',
                'game_file' => 'games/hard-drive.jpg',
                'options' => json_encode(['CPU', 'GPU', 'RAM', 'Motherboard', 'Hard Drive', 'SSD', 'Power Supply', 'Cooling Fan'])
            ],
            [
                'title' => 'SSD Assessment',
                'description' => 'Identify the computer part shown in the image',
                'question' => 'What is this computer component?',
                'answer' => 'SSD',
                'type' => 'guess_part',
                'status' => 'active',
                'thumbnail' => 'games/ssd.jpg',
                'game_file' => 'games/ssd.jpg',
                'options' => json_encode(['CPU', 'GPU', 'RAM', 'Motherboard', 'Hard Drive', 'SSD', 'Power Supply', 'Cooling Fan'])
            ],
            [
                'title' => 'Power Supply Assessment',
                'description' => 'Identify the computer part shown in the image',
                'question' => 'What is this computer component?',
                'answer' => 'Power Supply',
                'type' => 'guess_part',
                'status' => 'active',
                'thumbnail' => 'games/power-supply.jpg',
                'game_file' => 'games/power-supply.jpg',
                'options' => json_encode(['CPU', 'GPU', 'RAM', 'Motherboard', 'Hard Drive', 'SSD', 'Power Supply', 'Cooling Fan'])
            ],
            [
                'title' => 'Cooling Fan Assessment',
                'description' => 'Identify the computer part shown in the image',
                'question' => 'What is this computer component?',
                'answer' => 'Cooling Fan',
                'type' => 'guess_part',
                'status' => 'active',
                'thumbnail' => 'games/cooling-fan.jpg',
                'game_file' => 'games/cooling-fan.jpg',
                'options' => json_encode(['CPU', 'GPU', 'RAM', 'Motherboard', 'Hard Drive', 'SSD', 'Power Supply', 'Cooling Fan'])
            ]
        ];

        foreach ($questions as $question) {
            Game::updateOrCreate(
                ['title' => $question['title'], 'type' => 'guess_part'],
                $question
            );
        }
    }
}
