<?php

namespace App\Services;

use App\Models\MCode;

class MCodeService
{
    /**
     * コードリスト取得 by paCd.
     *
     * @param int $paCd　親コード
     * @return \App\Models\MCode　コードリスト
     */
    public function getCodesByPaCd($paCd)
    {
        //コードリスト　
        return MCode::where('pa_cd', $paCd)
                    ->orderBy('sort_order')
                    ->select('ch_cd as value', 'ch_name as label')
                    ->get();
    }
}
