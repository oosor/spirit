<?php

namespace App;

use App\Http\Controllers\GreekRuController;
use Illuminate\Database\Eloquent\Model;

class BibleBook extends Model
{
    protected $casts = [
        //'cr' => 'object',
        'a_1' => 'object',
        'a_2' => 'object',
        'a_3' => 'object',
        'a_4' => 'object',
    ];

    public function getCrAttribute($value)
    {
        $data = json_decode($value);
        $returnData = [];
        foreach($data->data as $i=>$val) {
            $rData = (object)[];
            $arData = explode(';', $val);
            foreach($arData as $key=>$adata) {
                if($key == 0) {
                    $rData->averse = $adata;
                    $rData->links = [];
                    continue;
                }
                $ddata = explode(',', $adata);
                $tmp = (object)[];
                $tmp->book = $ddata[0];
                $tmp->chapter = $ddata[1];
                $tmp->verse = $ddata[2];
                $tmp->ask = $ddata[3];
                $tmp->nameBook = $this->_getShortWord($ddata[0]);
                $rData->links[] = $tmp;
            }
            $returnData[] = $rData;
        }
        return $returnData;
    }


    private function _getShortWord($index) {
        return GreekRuController::getConst()->BOOK_NAMES_GREEK[($index)-1];
    }

}
