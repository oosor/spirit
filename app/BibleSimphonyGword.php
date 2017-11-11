<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BibleSimphonyGword extends Model
{




    public function getDetalAttribute($value)
    {
        $data = str_replace("<cite>", '<cite style="font-family: GrkV">', $value);



        $data = preg_replace_callback(['/<a href="(.+)<\/a>/iU', '/#([.\S]+)"/iU'], function ($matches) {
            if(count(explode(' ', $matches[1])) > 1) {
                $str = explode('" target="_blank">', $matches[1]);
                $addStr = '<a class="symphony" data="' . (explode('.', $str[0])[0]) . '">';
                $addStr .= str_replace('<b>', '<b data="' . (explode('.', $str[0])[0]) . '"">', $str[1]);
                $addStr .= '</a>';
            }
            else {
                $addStr = '<span class="word-abr">' . $matches[1] . '</span>';
            }
            return $addStr;
        }, $data);


        return $data;
    }

    public function getOtherAttribute($value)
    {
        $array = explode('~', $value);
        $data = [];
        foreach($array as $i => $el) {
            if ($i % 4 == 0) {
                $other = (object)[];
                $other->word = $el;
            }
            else if (($i + 3) % 4 == 0) {
                $other->code = $el;
            }
            else if (($i + 2) % 4 == 0) {
                $other->count = $el;
            }
            else if (($i + 1) % 4 == 0) {
                $other->ruWord = [];
                $ruWordArray = explode('_', $el);
                foreach($ruWordArray as $key => $val) {
                    if ($key % 2 == 0) {
                        $ruOther = (object)[];
                        $ruOther->word = $val;
                    }
                    else if (($key + 1) % 2 == 0) {
                        $ruOther->count = $val;
                        $other->ruWord[] = $ruOther;
                    }
                }

                $data[] = $other;
            }

        }

        return $data;
    }
}
