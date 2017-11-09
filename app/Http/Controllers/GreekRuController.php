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
use App\Src\Navigation;

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

        $pagination = new Navigation("BibleBook");

        $paginator = $pagination->getNamePagesLinks();

        $pag_1 = $pagination->getPrevNextLinks($data);

        $pagination = new Navigation("BibleRsv");

        $paginator->otherBookLinks = $pagination->getNamePagesLinks();

        return view('viewGreekRus', [
            'is'        => 'greek',
            'data'      => $data,
            'CONST'     => Navigation::getConst(),
            'pagination'=> $pag_1,
            'navigation'=> $paginator,
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

        $pagination = new Navigation("BibleBook");

        $data = BibleBook::where(['ot_nt' => $otNt, 'book' => $book, 'chapter' => $chapter])->first();

        if($request->view)
            return ['chapter'   => view('blocks.loads.greekRus', [
                'data'              => $data
                ])->render(),
                'pagination'    => view('blocks.paginator.paginator1', [
                    'pagination'    => $pagination->getPrevNextLinks($data)
                ])->render(),
                'links'         => view('blocks.loads.otherLinks', [
                    'data'              => $data,
                    'CONST'     => Navigation::getConst(),
                ])->render()
            ];

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
            //$otNt = $request->ot_nt ? $request->ot_nt : 'OT';
            $book = $request->book ? $request->book : '01_001';
            //$chapter = $request->chapter ? $request->chapter : 1;
            $cn = $request->cn ? $request->cn : 0;

            $data = BibleRsv::where([
                /*['ot_nt', $otNt],*/
                ['book', $book]
                /*['chapter', $chapter]*/
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

}
