<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Seed the application's category database.
     */
    public function run(): void
    {
        $categories = [

            [
                'name' => 'Mathematics',
                'description' => 'Books and learning resources related to Mathematics.',
                'parent_id' => null,
            ],

            [
                'name' => 'Sciences',
                'description' => 'Books and learning resources related to Science subjects.',
                'parent_id' => null,
            ],

            [
                'name' => 'Languages',
                'description' => 'Books and learning resources related to languages.',
                'parent_id' => null,
            ],

            [
                'name' => 'Humanities',
                'description' => 'Books and learning resources related to Humanities subjects.',
                'parent_id' => null,
            ],

            [
                'name' => 'Literature',
                'description' => 'Literature books, novels, plays and other reading materials.',
                'parent_id' => null,
            ],

            [
                'name' => 'Technical & Applied Sciences',
                'description' => 'Books related to technical and applied science subjects.',
                'parent_id' => null,
            ],

            [
                'name' => 'ICT & Computer Science',
                'description' => 'Books related to ICT, computing and computer science.',
                'parent_id' => null,
            ],

            [
                'name' => 'Business & Economics',
                'description' => 'Books related to business, commerce and economics.',
                'parent_id' => null,
            ],

            [
                'name' => 'Agriculture',
                'description' => 'Books and learning resources related to agriculture.',
                'parent_id' => null,
            ],

            [
                'name' => 'Reference Books',
                'description' => 'Reference materials, dictionaries, encyclopedias and guides.',
                'parent_id' => null,
            ],

            [
                'name' => 'Revision & Past Papers',
                'description' => 'Revision materials, examination papers and practice resources.',
                'parent_id' => null,
            ],

            [
                'name' => 'CBE Resources',
                'description' => 'Competency-Based Education learning resources.',
                'parent_id' => null,
            ],

        ];


        foreach ($categories as $category) {

            Category::firstOrCreate(

                [
                    'name' => $category['name'],
                ],

                $category

            );

        }
    }
}