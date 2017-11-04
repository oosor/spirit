<?php
/**
 * Created by PhpStorm.
 * User: dj
 * Date: 28.10.17
 * Time: 15:32
 */

namespace App\Src;


use App\BibleBook;
use App\BibleRsv;

class Navigation
{

    private $_model;

    public function __construct($model)
    {
        $this->_model = $model;
    }

    function getNamePagesLinks() {

        if($this->_model == 'BibleBook')
            $all = $this->_getModel()::select(['ot_nt', 'book', 'chapter'])->get();
        else if($this->_model == 'BibleRsv')
            $all = $this->_getModel()::select(['c'])->where('c', '!=', '')->get();

        $data = (object)[];
        $data->numberLinks = [];
        $data->bookLinks = [];
        $tmp = '';
        //return $all;
        foreach($all as $one) {
            $object = $one;
            if($this->_model == 'BibleBook') {
                $object->name = Navigation::getConst()->BOOK_NAMES_GREEK[array_search($one->book, Navigation::getConst()->BOOK_LINKS_GREEK)];
                $object->href = '?ot_nt=' . $one->ot_nt . '&book=' . $one->book . '&chapter=' . $one->chapter;

                $ttmp = $one->book;
                if($tmp != $one->book) {
                    $data->bookLinks[$one->book] = $this->getNumberPagesLinks(clone $object);
                    $data->numberLinks[$one->book] = [];
                    $tmp = $one->book;
                }
            }
            else if($this->_model == 'BibleRsv') {
                $object->name = Navigation::getConst()->BOOK_NAMES_RU[((int)(explode('_', $object->c)[0])) - 1];
                $object->href = '?book=' . $one->c;

                $ttmp = explode('_', $one->c)[0] . '_';
                if($tmp != $ttmp) {
                    $data->bookLinks[$ttmp] = $this->getNumberPagesLinks(clone $object);
                    $data->numberLinks[$ttmp] = [];
                    $tmp = $ttmp;
                }
            }

            $this->getNumberChapterLinks($object);




            //dd($data->bookLinks['Gen']->numberLinks);

            $data->numberLinks[$ttmp][] = $object;
        }
        //dd($data);
        return $data;
    }

    function getNumberPagesLinks($object) {
        if($this->_model == 'BibleBook')
            $object->href = '?ot_nt=' . $object->ot_nt . '&book=' . $object->book;
        else if($this->_model == 'BibleRsv')
            $object->href = '?book=' . $object->c;

        $object->numberLinks = [];
        return $object;
    }

    function getNumberChapterLinks($object) {
        if($this->_model == 'BibleBook')
            $object->href = '?ot_nt=' . $object->ot_nt . '&book=' . $object->book . '&chapter=' . $object->chapter;
        else if($this->_model == 'BibleRsv')
            $object->href = '?book=' . $object->c;

        return $object;
    }

    function getPrevNextLinks($activeModel) {
        //$count = Navigation::getConst()->COUNT_CHAPTER_BOOKS[$activeModel->book];
        if($this->_model == 'BibleBook')
            $models = $this->_getModel()::select(['ot_nt', 'book', 'chapter'])->where('book', $activeModel->book)->get();
        else if($this->_model == 'BibleRsv')
            $models = $this->_getModel()::select(['c'])->where('c', 'like', (explode('_', $activeModel->c)[0] . '_%'))->get();

        $data = [];
        foreach ($models as $model) {
            $obj = $model;
            $obj->active = ($this->_model == 'BibleBook') ? $activeModel->chapter == $model->chapter : $activeModel->c == $model->c;
            $this->getNumberChapterLinks($obj);
            $data[] = $obj;
        }

        return $data;
    }




    private function _getModel() {
        switch($this->_model) {
            case 'BibleBook':
                return BibleBook::class;
            case 'BibleRsv':
                return BibleRsv::class;
        }
    }

    static function getConst() {
        /*//[46 => 'Мал'
        //'76' => 'Евр'
        //51 => Мф
        //67 => Еф,
        //77 => Дан(Ф)  -------------
        //78 => Дан
        //
        //
        //28 => Ис
        //30 => Плач
        //31 => Посл.Иер
        // => Вар
        //34 => Дан(Ф)
        //35 => Ос
        //15 => Езд
        //18 => Тов
        //19 => Иудифь
        //Быт => 1
        //5 => Втор
        //8 => Руфь
        //20 => Есф
        //24 => Еккл
        //25 => Песн
        //];*/
        $BOOK_LINKS_GREEK = [
            'Gen', 'Ex', 'Le', 'Nu', 'De', '', '', 'Ru', '', '', '', '', '', '',
            'Ezr', '', '', 'Tov', 'Judith', 'Es', '', '', '',
            'Ec', 'SS', '', '', 'Isa', '', 'Lam', 'ep_Ieremiya',
            'Var', 'Var', 'Da_F', /*'Da',*/ 'Hos', 'Joel',
            'Amos', 'Obad', 'Jon', 'Mic', 'Nah', 'Hab', 'Zeph', 'Hag', 'Zech', 'Mal',
            '', '', '', '',
            'Mt', 'Mk', 'Lk', 'Jn', 'Acts', 'Jas', '1Pet', '2Pet', '1Jn', '2Jn',
            '3Jn', 'Jude', 'Rom', '1Cor', '2Cor', 'Gal', 'Eph', 'Phil', 'Col', '1Thes',
            '2Thes', '1Tim', '2Tim', 'Tit', 'Phlm', 'Heb','Rev', 'Da'
        ];

        $BOOK_NAMES_GREEK = [
            'Быт', 'Исх', 'Лев', 'Чис','Втор', '', '', 'Руфь', '', '', '', '', '', '',
            'Езд', '', '', 'Тов', 'Иудифь',
            'Есф', '', '', '', 'Еккл', 'Песн', '', '', 'Ис', '', 'Плач', 'Посл.Иер',
            'Вар', 'Вар', 'Дан(Ф)', /*'Дан',*/ 'Ос',
            'Иоил', 'Ам', 'Авд', 'Иона', 'Мих', 'Наум', 'Авв', 'Соф', 'Агг','Зах',
            'Мал', '', '', '', '', 'Мф', 'Мк', 'Лк', 'Ин', 'Деян', 'Иак', '1Пет', '2Пет', '1Ин',
            '2Ин','3Ин', 'Иуд', 'Рим', '1Кф', '2Кф', 'Гал', 'Еф', 'Флп', 'Кол',
            '1Фес','2Фес', '1Тим','2Тим', 'Тит','Флм', 'Евр','Откр', 'Дан'
        ];
        $BOOK_NAMES_RU = [
            'Быт', 'Исх', 'Лев', 'Чис','Втор', 'Нав', 'Суд','Руфь', '1Цар','2Цар', '3Цар','4Цар',
            '1Пар','2Пар', 'Езд','Неем', '2Езд','Тов', 'Иудифь','Есф', 'Иов','Пс', 'Притч',
            'Еккл', 'Песн', 'Прем','Сир', 'Ис','Иер', 'Плач','Посл.Иер',
            'Вар','Иез', 'Дан','Ос', 'Иоил','Ам', 'Авд','Иона', 'Мих','Наум', 'Авв',
            'Соф', 'Агг','Зах', 'Мал', '1Мак', '2Мак', '3Мак', '3Езд',
            'Мф', 'Мк','Лк', 'Ин','Деян', 'Иак','1Пет', '2Пет',
            '1Ин', '2Ин','3Ин', 'Иуд','Рим', '1Кф','2Кф', 'Гал','Еф', 'Флп',
            'Кол', '1Фес','2Фес', '1Тим','2Тим', 'Тит','Флм', 'Евр','Откр'
        ];
        $COUNT_CHAPTER_BOOKS = [
            'Gen' => 50, 'Ex' => 40, 'Le' => 27, 'Nu' => 36, 'De' => 34, 'Ru' => 4,
            'Ezr' => 10, 'Tov' => 14, 'Judith' => 16, 'Es' => 10,
            'Ec' => 12, 'SS' => 8, 'Isa' => 66, 'Lam' => 5, 'ep_Ieremiya' => 1,
            'Var' => 5, 'Var' => 5, 'Da_F' => 12, 'Da' => 14, 'Hos' => 14, 'Joel' => 3,
            'Amos' => 9, 'Obad' => 1, 'Jon' => 4, 'Mic' => 7, 'Nah' => 3, 'Hab' => 3, 'Zeph' => 3, 'Hag' => 2, 'Zech' => 14, 'Mal' => 4,
            'Mt' => 28, 'Mk' => 16, 'Lk' => 24, 'Jn' => 21, 'Acts' => 28, 'Jas' => 5, '1Pet' => 5,
            '2Pet' => 3, '1Jn' => 5, '2Jn' => 1,
            '3Jn' => 1, 'Jude' => 1, 'Rom' => 16, '1Cor' => 16, '2Cor' => 13, 'Gal' => 6,
            'Eph' => 6, 'Phil' => 4, 'Col' => 4, '1Thes' => 5,
            '2Thes' => 3, '1Tim' => 6, '2Tim' => 4, 'Tit' => 3, 'Phlm' => 1, 'Heb' => 13,
            'Rev' => 22
        ];
        return (object)[
            'BOOK_LINKS_GREEK'      => $BOOK_LINKS_GREEK,
            'BOOK_NAMES_GREEK'      => $BOOK_NAMES_GREEK,
            'BOOK_NAMES_RU'         => $BOOK_NAMES_RU,
            'COUNT_CHAPTER_BOOKS'   => $COUNT_CHAPTER_BOOKS
        ];
    }

}