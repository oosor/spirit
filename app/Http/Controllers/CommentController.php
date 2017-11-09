<?php

namespace App\Http\Controllers;

use App\BibleComment;
use App\BibleRsv;
use App\Src\Navigation;
use Illuminate\Http\Request;

class CommentController extends Controller
{


    function index(Request $request) {

        $code = $request->code ?? $request->book ?? null;

        $data = BibleComment::where('code', $code)->first() ?? abort(404);

        return view('comment', [
            'is'                => 'comment',
            'data'              => $data,
            'CONST'             => Navigation::getConst(),
            'navigation'        => $this->getPaginator(),
            'pagination'        => (new Navigation("BibleComment"))->getPrevNextLinks($data),
            'property'          => [
                'book'              => $code
            ]
        ]);
    }


    function commentBook(Request $request) {

        $code = $request->code ?? $request->book ?? null;

        $data = BibleComment::where('code', $code)->first() ?? abort(404);

        return [
            'chapter'       => view('blocks.loads.comment', [
                'data'              => $data,
                'CONST'             => Navigation::getConst(),
            ])->render(),
            'pagination'    => view('blocks.paginator.paginator3', [
                'pagination'    => (new Navigation("BibleComment"))->getPrevNextLinks($data)
            ])->render()
        ];
    }

    function commentData(Request $request) {

        $tmp = explode('.', $request->code);
        $code = count($tmp) > 1 ? $tmp[1] : $request->code;

        $data = BibleRsv::where('c', $code)->first() ?? abort(404);

        return [
            'chapter'   => view('blocks.loads.bible', [
                'data'              => $data
            ])->render()
        ];
    }


    function getPaginator() {
        $pagination = new Navigation("BibleRsv");

        $paginator = $pagination->getNamePagesLinks();

        $pagination = new Navigation("BibleBook");

        $paginator->otherBookLinks = $pagination->getNamePagesLinks();

        return $paginator;
    }
}
