<?php

namespace App;

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




}
