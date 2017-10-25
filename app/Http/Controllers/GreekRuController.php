<?php

namespace App\Http\Controllers;

use App\BibleBook;
use App\BibleHelp;
use App\BibleRsv;
use App\BibleSimphonyGword;
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

        $data = BibleBook::where(['ot_nt' => $otNt, 'book' => $book, 'chapter' => $chapter])->get();

        return view('viewGreekRus', [
            'data'      => $data,
            'property'  => [
                'ot_nt'     => $otNt,
                'book'      => $book,
                'chapter'   => $chapter,
                'cn'        => $cn,
            ]
        ]);
    }


    function wordGreek(Request $request) {

        $sword = str_replace(['.', ','], '', $request->word);
        $data = BibleWordsGreek::where([
            ['code', $request->code],
            ['header', 'like binary', "$sword %"]
        ])->first();


        return [
            'word' => $data
        ];
    }

    function wordRu(Request $request) {

        $sword = str_replace(['.', ','], '', $request->word);

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

        $sword = str_replace(['.', ','], '', $request->word);

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
        $otNt = $request->ot_nt ? $request->ot_nt : 'OT';
        $book = $request->book ? $request->book : 'Gen';
        $chapter = $request->chapter ? $request->chapter : 1;
        $cn = $request->cn ? $request->cn : 0;

        $data = BibleRsv::where(['ot_nt' => $otNt, 'book' => $book, 'chapter' => $chapter])->get();

        return $data;
    }
}
