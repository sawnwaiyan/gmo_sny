<?php

namespace Database\Seeders;

use App\Models\Asking;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AskingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $questionnaires = [
            'questionnaire' => [
                [
                    'question' => '1.サービスに満足してますか？',
                    'options' => [
                        '１．不満足',
                        '２．普通',
                        '３．満足'
                    ]
                ],
                [
                    'question' => '２.何のメニューが好きですか？',
                    'options' => [
                        '１．A',
                        '２．B',
                        '３．C',
                        '４．D'
                    ]
                ],
                [
                    'question' => '改善が必要なところはありますか？',
                    'options' => [
                        '１．あり',
                        '２．なし'
                    ]
                ]
            ]
        ];
        Asking::create([
            'title' => 'First Tile',
            'questionnaire' => json_encode($questionnaires['questionnaire']),
            'header_text' => 'Header Text',
            'footer_text' => 'Footer Text',
            'logo' => 'test/logo.jpq',
            'bg_color' => '#ffffff',
            'text_color' => '#000000',
            'count_view_flg' => 0,
            'coupon_id' => 1,
            'open_flg' => 0,
            'tag' => 'tag',
            'biko' => ''
        ]);
    }
}
