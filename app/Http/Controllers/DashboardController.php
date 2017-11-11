<?php

namespace App\Http\Controllers;

use App\Src\Navigation;
use Illuminate\Http\Request;

class DashboardController extends Controller
{


    function index(Request $request) {


        return view('dashboard', [
            'is'                => 'home',
            'navigation'        => $this->getPaginator(),
        ]);
    }

    function about(Request $request) {


        return view('about', [
            'is'                => 'about',
            'navigation'        => $this->getPaginator(),
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
