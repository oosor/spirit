<?php

namespace App\Http\Controllers;

use App\BibleBook;
use App\BibleHelp;
use App\BibleRsv;
use App\BibleSimphonyGword;
use App\BibleSimphonyWord;
use App\BibleWordsGreek;
use App\BibleWordsRu;
use Illuminate\Http\Request;

class GreekRuController extends Controller
{

    public function __construct()
    {
    }

    function index(Request $request) {

        $otNt = $request->ot_nt ? $request->ot_nt : 'OT';
        $book = $request->book ? $request->book : 'Gen';
        $chapter = $request->chapter ? $request->chapter : 1;
        $cn = $request->cn ? $request->cn : 0;

        $data = BibleBook::where(['ot_nt' => $otNt, 'book' => $book, 'chapter' => $chapter])->first()
            ?? abort(404);

        return view('viewGreekRus', [
            'data'      => $data,
            'CONST'     => GreekRuController::getConst(),
            'property'  => [
                'ot_nt'     => $otNt,
                'book'      => $book,
                'chapter'   => $chapter,
                'cn'        => $cn,
            ]
        ]);
    }


    function wordGreek(Request $request) {

        $sword = str_replace(['.', ',' , ':'], '', $request->word);
        $data = BibleWordsGreek::where([
            ['code', $request->code],
            ['header', 'like binary', "$sword %"]
        ])->first();


        return [
            'word' => $data
        ];
    }

    function wordRu(Request $request) {

        $sword = str_replace(['.', ',', ';', ':', '!', '?', '″'], '', $request->word);

        $data = BibleWordsRu::where([
            ['header', $sword]
        ])->first();


        return [
            'word' => $data
        ];
    }


    function chapterGreek(Request $request) {

        $otNt = $request->ot_nt ? $request->ot_nt : 'OT';
        $book = $request->book ? $request->book : 'Gen';
        $chapter = $request->chapter ? $request->chapter : 1;
        $cn = $request->cn ? $request->cn : 0;

        $data = BibleBook::where(['ot_nt' => $otNt, 'book' => $book, 'chapter' => $chapter])->get();

        return $data;
    }

    function symphonyGWord(Request $request) {

        $sword = str_replace(['.', ',', ';', ':', '!', '[', ']', '?', '″'], '', $request->word);

        $data = BibleSimphonyGword::where([
            ['code', $request->code],
            ['word', $sword]
        ])->first();


        return [
            'word' => $data
        ];
    }

    function abrWord(Request $request) {

        return BibleHelp::where('name', $request->word)->first();
    }

    function ruBible(Request $request) {

        if($request->is) {
            $otNt = $request->ot_nt ? $request->ot_nt : 'OT';
            $book = $request->book ? $request->book : 'Gen';
            $chapter = $request->chapter ? $request->chapter : 1;
            $cn = $request->cn ? $request->cn : 0;

            $data = BibleRsv::where([
                ['ot_nt', $otNt],
                ['book', 'like', $book.'%'],
                ['chapter', $chapter]
            ]);
        }
        else {
            $code = $request->code ? $request->code : '01_001';
            $word = $request->word ? $request->word : '';

            $data = BibleRsv::where('c', $code);
        }


        return $data->first() ?? abort(404);
    }

    function ruSimphony(Request $request) {

        $sword = str_replace(['.', ',', ';', ':', '!', '[', ']', '?', '″', '-'], '', $request->word);
        $data = BibleSimphonyWord::where([
            ['word', $sword]
        ])->first();


        return [
            'word' => $data
        ];
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
            '2Thes', '1Tim', '2Tim', 'Tit', 'Phlm', 'Heb','Rev', 'Da'];

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
        return (object)[
            'BOOK_LINKS_GREEK'  => $BOOK_LINKS_GREEK,
            'BOOK_NAMES_GREEK'  => $BOOK_NAMES_GREEK,
            'BOOK_NAMES_RU'     => $BOOK_NAMES_RU
        ];
    }
}
