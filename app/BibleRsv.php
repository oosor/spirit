<?php

namespace App;

use App\Src\Navigation;
use Illuminate\Database\Eloquent\Model;

class BibleRsv extends Model
{
    protected $table = 'bible_rsv';

    protected $casts = [
        //'a' => 'object',
    ];


    public function getAAttribute($value)
    {

        $data = json_decode($value);
        foreach($data->data as $k=>$d) {
            $data->data[$k] = preg_replace_callback(['/ <\d+>/U', '/<b>(\d+)<\/b>/U'], function($matches) {
                if(count(explode('<b>', $matches[0])) > 1) {
                    return '<b class="greek-chapter ru-bible">' . $matches[1] . '</b>';
                }
                return '';
            }, $d);
        }

        return $data;

    }


    public function getFAttribute($value)
    {

        $data = json_decode($value);
        $returnData = [];
        foreach($data->data as $i=>$el) {
            if ($i % 2 == 0) {
                $other = (object)[];
                $other->verse = $el;
            }
            else if (($i + 1) % 2 == 0) {
                $other->links = [];
                $arr = explode(';', $el);
                foreach($arr as $ar) {
                    $obj = (object)[];
                    $_ar = explode(',', $ar);
                    foreach($_ar as $k=>$ch) {
                        if ($k % 4 == 0) {
                            $obj->digit1 = $ch;
                        }
                        else if(($k + 3) % 4 == 0) {
                            $obj->digit2 = $ch;
                        }
                        else if(($k + 2) % 4 == 0) {
                            $obj->digit3 = $ch;
                        }
                        else if(($k + 1) % 4 == 0) {
                            $obj->book = $ch;
                        }
                    }
                    $other->links[] = $obj;
                }
                $returnData[] = $other;
            }
        }

        return $returnData;

    }


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
        return Navigation::getConst()->BOOK_NAMES_RU[($index)-1];
    }




}
