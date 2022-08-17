<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Carbon\Carbon;
use DB;

class SalaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = Carbon::now();
        DB::table('salas')->insert([
            ['nombre' => 'Sala blanca', 'active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Sala azul', 'active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Sala amarilla', 'active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Sala roja', 'active' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['nombre' => 'Sala purpura', 'active' => 1, 'created_at' => $now, 'updated_at' => $now],
        ]);
    }
}
