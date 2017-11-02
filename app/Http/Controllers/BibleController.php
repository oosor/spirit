<?php

namespace App\Http\Controllers;

use App\BibleRsv;
use App\Src\Navigation;
use Illuminate\Http\Request;

class BibleController extends Controller
{

    function index(Request $request) {

        $otNt = $request->ot_nt ? $request->ot_nt : 'OT';
        $book = $request->book ? $request->book : 'Gen';
        $chapter = $request->chapter ? $request->chapter : 1;
        $cn = $request->cn ? $request->cn : 0;

        $data = BibleRsv::where(['ot_nt' => $otNt, 'book' => $book, 'chapter' => $chapter])->first()
            ?? abort(404);

        $pagination = new Navigation("BibleRsv");
        //return $pagination->getPrevNextLinks($data);
        //return json_encode($pagination->getNamePagesLinks());


        return view('viewBible', [
            'data'      => $data,
            'CONST'     => Navigation::getConst(),
            'pagination'=> $pagination->getPrevNextLinks($data),
            'navigation'=> $pagination->getNamePagesLinks(),
            'property'  => [
                'ot_nt'     => $otNt,
                'book'      => $book,
                'chapter'   => $chapter,
                'cn'        => $cn,
            ]
        ]);
    }
}
