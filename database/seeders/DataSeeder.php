<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Zonal;
use App\Models\Category;


class DataSeeder extends Seeder
{
    /**
     */
    public function run(): void
    {
        //
        $zonals=[
            'Dhaka North',
            'Dhaka South',
            'Chittagong',
            'Khulna',
            'Sylhet',
            'Rajshahi'
            ];

            foreach($zonals as $zone)
                {
                    Zonal::create(['name'=>$zone]);
                }


                $categories=[
            'Logical',
            'Physical',
            'IIG',
            'NTTN',

                ];

                foreach ($categories as $category ) {
                    Category::create(['name'=> $category]);
                }
            
        }
    }

        
    

