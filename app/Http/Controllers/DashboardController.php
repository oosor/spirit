<?php

namespace App\Http\Controllers;

use App\BibleComment;
use Illuminate\Http\Request;

class DashboardController extends Controller
{

    public function __construct()
    {

    }

    function tmp() {

        /*$bible = BibleComment::find(2);
        return $bible->text;*/

        /*$data = scandir('../../../parse/S/', 0);

        foreach ($data as $key=>$_data) {
            if($key < 2) continue;
            if(count(explode('_', $_data)) == 1) continue;


            $dd = file_get_contents("http://localhost/pro/parse/S/".$_data);


            //return explode('.', $_data)[0];
            $_dd = explode('<tr><td>', $dd)[1];
            $_dd = explode('</td></tr>', $_dd)[0];

            //HREF="../RSV/01_001.htm#1"
            $pattern = "/HREF=\"\.\.\/(\w+)\/(\w+)\.\w+\#([\d+\-]+)\"/i";
            $replacement = "data=\"\${1}.\${2}.\${3}\"";
            $_dd = preg_replace($pattern, $replacement, $_dd);

            $pattern = [
                "/onmouseover=\"[^\"]+\"\s?/i",
                "/onmouseout=\"[^\"]+\"\s?/i",
                "/ ALIGN=\"JUSTIFY\"/i"
                ];
            $replacement = "";
            $_dd = preg_replace($pattern, $replacement, $_dd);


            /*$_dd = str_replace([' ALIGN="JUSTIFY"'], "", $_dd);
            $_dd = str_replace([' ALIGN="JUSTIFY"'], "", $_dd);*/
            //return view('tmp', ['data' => $_dd]);

            /*$_dd = iconv('cp1251', 'utf8', $_dd);

            $bible = new BibleComment();
            //return $_dd;
            $bible->code = explode('.', $_data)[0];
            $bible->text = $_dd/*json_encode([$_dd], JSON_UNESCAPED_UNICODE)*/
            //$bible->save();*/

        //}


        return 'ok';
    }

}
