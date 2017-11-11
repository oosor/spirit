<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BibleWordsGreek extends Model
{
    protected $table = 'bible_words_gree';



    public function getHeaderAttribute($value)
    {
        $array = explode(' ', $value);
        $data = (object)[];
        foreach($array as $i => $el) {
            switch($i) {
                case 0:
                    $data->greek = $el;
                    break;
                case 1:
                    if($el == '0') return $data;
                    $data->otherGreek = (object)[];
                    $data->otherGreek->greek = $el;
                    break;
                case 2:
                    $data->otherGreek->code = $el;
                    break;
                case 3:
                    if(ctype_digit($el))
                        $data->numberStrong = $el;
                    else {
                        $glArray = explode('~', $el);
                        $data->gl = [];
                        foreach($glArray as $gl) {
                            $data->gl[] = $gl;
                        }
                    }
                    break;
                case 4:
                    $glArray = explode('~', $el);
                    $data->gl = [];
                    foreach($glArray as $gl) {
                        $data->gl[] = $gl;
                    }
                    break;
            }

        }

        return $data;

    }

    public function getLinksAttribute($value)
    {
        $array = explode('~', $value);
        $data = [];
        foreach($array as $i => $el) {
            if (($i) % 3 == 0) {
                $data[floor($i/3)] = [];
                $data[floor($i/3)][] = $el;
            }
            else if(($i+2)%3 == 0) {
                $data[floor($i/3)][] = $el;
            }
            else if(($i+1)%3 == 0) {
                $verseArray = explode(';', $el);
                $data[floor($i/3)][] = [];
                foreach($verseArray as $verse) {
                    $kroshVerseArray = explode(',', $verse);
                    $sdata = (object)[];
                    foreach($kroshVerseArray as $k => $kroshVerse) {
                        if(strrpos($kroshVerse, '..') === true) {
                            $sdata->nameBook = $kroshVerse;
                            $data[floor($i/3)][2][] = $sdata;
                            break;
                        }
                        else {
                            if (($k) % 3 == 0) {
                                $sdata->ot_nt_gl = $kroshVerse;
                            }
                            else if(($k+2)%3 == 0) {
                                $sdata->nameBook = $kroshVerse;
                            }
                            else if(($k+1)%3 == 0) {
                                $sdata->numberBook = $kroshVerse;
                                $data[floor($i/3)][2][] = $sdata;
                            }
                        }
                    }
                }
            }
        }
        return $data;
    }

    public function getEmptysAttribute($value)
    {
        $array = explode('~', $value);
        $data = [];
        $other = (object)[];
        foreach($array as $i => $el) {
            if ($i % 2 == 0) {
                $other->code = $el;
            } else if (($i + 1) % 2 == 0) {
                $other->word = $el;
                $data[] = $other;
            }
        }
        return $data;
    }
}
