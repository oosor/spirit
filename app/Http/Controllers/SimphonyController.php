<?php

namespace App\Http\Controllers;

use App\BibleSimphonyGword;
use App\BibleWordsGreek;
use App\BibleWordsRu;
use App\Src\Navigation;
use Illuminate\Http\Request;

class SimphonyController extends Controller
{

    function index(Request $request) {

        $word = $request->word ?? null;

        $data = BibleWordsGreek::where('code', $word)->get();
        if(count($data) == 0) abort(404);
        //return ($data);

        return view('simphonyGreek', [
            'is'                => 'simphony-greek',
            'data'              => $data,
            'navigation'        => $this->getPaginator(),
            'links'             => Navigation::getGreekSimphony()
        ]);
    }


    function ruSimphony(Request $request) {
        $word = $request->word ?? null;

        $data = BibleWordsRu::where('code', $word)->get();
        if(count($data) == 0) abort(404);


        return view('simphonyGreek', [
            'is'                => 'simphony-ru',
            'data'              => $data,
            'navigation'        => $this->getPaginator(),
            'links'             => Navigation::getRuSimphony()
        ]);
    }

    function greekViewRender(Request $request) {

        $word = $request->word ?? null;

        $data = BibleWordsGreek::where('code', $word)->get();
        if(count($data) == 0) abort(404);

        return view('blocks.loads.simphonyGreek', [
            'is'                => 'simphony-greek',
            'data'              => $data,
        ]);
    }

    function ruViewRender(Request $request) {

        $word = $request->word ?? null;

        $data = BibleWordsRu::where('code', $word)->get();
        if(count($data) == 0) abort(404);

        return view('blocks.loads.simphonyRu', [
            'is'                => 'simphony-ru',
            'data'              => $data,
        ]);
    }

    function greekSimphonyWord(Request $request) {

        $word = $request->word ?? null;

        $data = BibleSimphonyGword::where('code', $word)->get();
        if(count($data) == 0) abort(404);

        return view('simphonyGreek', [
            'is'                => 'simphony-greek-word',
            'data'              => $data,
            'navigation'        => $this->getPaginator(),
            'links'             => Navigation::getGreekSimphonyWord()
        ]);
    }


    function greekWordViewRender(Request $request) {

        $word = $request->word ?? null;

        $data = BibleSimphonyGword::where('code', $word)->get();
        if(count($data) == 0) abort(404);

        return view('blocks.loads.simphonyGreekWord', [
            'is'                => 'simphony-greek-word',
            'data'              => $data,
        ]);
    }

    function getPaginator() {
        $pagination = new Navigation("BibleRsv");

        $paginator = $pagination->getNamePagesLinks();

        $pagination = new Navigation("BibleBook");

        $paginator->otherBookLinks = $pagination->getNamePagesLinks();

        return $paginator;
    }

}
