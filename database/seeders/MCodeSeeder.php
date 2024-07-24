<?php

namespace Database\Seeders;

use App\Models\MCode;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //DB::table('m_codes')->truncate();
        MCode::insert([[
            'pa_cd' => 'COM001',
            'ch_cd' => 0,
            'pa_name' => '公開フラグ',
            'ch_name' => '非公開',
            'sort_order' => 1,
            'is_deleted' => 0,
            'created_by' => 'system',
            'updated_by' => 'system',
        ], [
            'pa_cd' => 'COM001',
            'ch_cd' => 1,
            'pa_name' => '公開フラグ',
            'ch_name' => '公開',
            'sort_order' => 2,
            'is_deleted' => 0,
            'created_by' => 'system',
            'updated_by' => 'system',
        ]]);
    }
}
