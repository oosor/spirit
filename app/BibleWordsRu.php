<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BibleWordsRu extends Model
{

    protected $table = 'bible_words_ru';


    public function getLinksAttribute($value)
    {
        $array = explode(' ', $value);
        $data = [];
        foreach($array as $i => $el) {
            if ($i % 2 == 0) {
                $other = (object)[];
                $other->code = $el;
            } else if (($i + 1) % 2 == 0) {
                $other->word = $el;
                $data[] = $other;
            }
        }
        return $data;
    }

    public function getEmptysAttribute($value)
    {
        $array = explode(';', $value);
        return array_slice($array, 0, count($array)-1);
    }
}
