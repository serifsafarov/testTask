<?php

namespace Database\Seeders;

use App\Models\Gift;
use Illuminate\Database\Seeder;

class GiftsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Gift::factory()->count(100)->create();
    }
}
