<?php

namespace App\Http\Controllers;

use App\BibleRsv;
use App\Src\Navigation;
use Illuminate\Http\Request;

class BibleController extends Controller
{

    function index(Request $request) {

        //$otNt = $request->ot_nt ? $request->ot_nt : 'OT';
        $book = $request->book ? $request->book : '01_001';
        //$chapter = $request->chapter ? $request->chapter : 1;
        $cn = $request->cn ? $request->cn : 0;

        $data = BibleRsv::where(['c' => $book/*, 'book' => $book, 'chapter' => $chapter*/])->first()
            ?? abort(404);


        $pagination = new Navigation("BibleRsv");


        $paginator = $pagination->getNamePagesLinks();

        $pag_1 = $pagination->getPrevNextLinks($data);

        $pagination = new Navigation("BibleBook");

        $paginator->otherBookLinks = $pagination->getNamePagesLinks();

        return view('viewBible', [
            'is'        => 'ru',
            'data'      => $data,
            'CONST'     => Navigation::getConst(),
            'pagination'=> $pag_1,
            'navigation'=> $paginator,
            'property'  => [
                //'ot_nt'     => $otNt,
                'book'      => $book,
                //'chapter'   => $chapter,
                'cn'        => $cn,
            ]
        ]);
    }


    function chapterRu(Request $request) {

        //$otNt = $request->ot_nt ? $request->ot_nt : 'OT';
        $book = $request->book ? $request->book : 'Gen';
        //$chapter = $request->chapter ? $request->chapter : 1;
        $cn = $request->cn ? $request->cn : 0;

        $pagination = new Navigation("BibleRsv");

        $data = BibleRsv::where(['c' => $book])->first();

        if($request->view)
            return ['chapter'   => view('blocks.loads.bible', [
                'data'              => $data
            ])->render(),
                'pagination'    => view('blocks.paginator.paginator2', [
                    'pagination'    => $pagination->getPrevNextLinks($data)
                ])->render(),
                'links'         => view('blocks.loads.otherLinks2', [
                    'data'              => $data,
                    'CONST'     => Navigation::getConst(),
                ])->render()
            ];

        return $data;
    }

}
