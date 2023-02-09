<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Category::factory()->count(5)->create();
        try {
            for ($i=0; $i < 10; $i++) { 
                $arr1 = ['Non-Pangan','Pangan'];
                $arr2 = ['Makanan Berat', 'Makanan Ringan'];
                $arr3 = ['Kayu', 'Semen', 'Bata'];
                $category_type = array_rand($arr1);
                $p = array_rand($arr2);
                $np = array_rand($arr3);
                if (!strcmp($arr1[$category_type], "Non-Pangan")) {
                    $category_name = $arr3[$np];
                } else {
                    $category_name = $arr2[$p];
                }
                $c = str_replace(['-', ' '], '', $arr1[$category_type]);
                $n = str_replace(' ', '', $category_name);
                $id = preg_replace('/([a-z])/', '', $c).'-'.preg_replace('/([a-z])/', '', $n);
                
                Category::firstOrCreate([
                    'category_id' => $id,
                    'category_name' => $category_name,
                    'category_type' => $arr1[$category_type],
                ]);
            }
        } catch (QueryException $e) {
            // $viewPermission = Category::class->where('name', 'view_user')->first;
        }

    }
}
