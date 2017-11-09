<?php
/**
 * Created by PhpStorm.
 * User: dj
 * Date: 28.10.17
 * Time: 15:32
 */

namespace App\Src;


use App\BibleBook;
use App\BibleComment;
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
                $object->name = Navigation::getConst()->BOOK_FULL_NAMES_GREEK[array_search($one->book, Navigation::getConst()->BOOK_LINKS_GREEK)];
                $object->href = '?ot_nt=' . $one->ot_nt . '&book=' . $one->book . '&chapter=' . $one->chapter;

                $ttmp = $one->book;
                if($tmp != $one->book) {
                    $data->bookLinks[$one->book] = $this->getNumberPagesLinks(clone $object);
                    $data->numberLinks[$one->book] = [];
                    $tmp = $one->book;
                }
            }
            else if($this->_model == 'BibleRsv') {
                $object->name = Navigation::getConst()->BOOK_FULL_NAMES_RU[((int)(explode('_', $object->c)[0])) - 1];
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
        else if($this->_model == 'BibleComment')
            $object->href = '?code=' . $object->code;

        return $object;
    }

    function getPrevNextLinks($activeModel) {
        //$count = Navigation::getConst()->COUNT_CHAPTER_BOOKS[$activeModel->book];
        if($this->_model == 'BibleBook')
            $models = $this->_getModel()::select(['ot_nt', 'book', 'chapter'])->where('book', $activeModel->book)->get();
        else if($this->_model == 'BibleRsv')
            $models = $this->_getModel()::select(['c'])->where('c', 'like', (explode('_', $activeModel->c)[0] . '_%'))->get();
        else if($this->_model == 'BibleComment')
            $models = $this->_getModel()::select(['code'])->where('code', 'like', (explode('_', $activeModel->code)[0] . '_%'))->get();


        $data = [];
        foreach ($models as $model) {
            $obj = $model;

            if($this->_model == 'BibleBook'){
                $obj->active = $activeModel->chapter == $model->chapter;
            }
            else if($this->_model == 'BibleRsv') {
                $obj->active = $activeModel->c == $model->c;
            }
            else if($this->_model == 'BibleComment') {
                $obj->active = $activeModel->code == $model->code;
            }
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
            case 'BibleComment':
                return BibleComment::class;
        }
    }

    static function getGreekSimphony() {
        return ["41","A","4241","AB","4741","AG","4D41","AM","5041","AP","5241","AR","5341","AS","6141","Aa","6241","Ab","6741","Ag","6441","Ad","6541","Ae","7A41","Az","6841","Ah","7941","Ay","6941","Ai","6B41","Ak","6C41","Al","6D41","Am","6E41","An","6A41","Aj","6F41","Ao","7041","Ap","7241","Ar","7341","As","7441","At","7541","Au","6641","Af","7841","Ax","6341","Ac","7641","Av","4142","BA","6142","Ba","6542","Be","6842","Bh","6942","Bi","6C42","Bl","6F42","Bo","7242","Br","7642","Bv","4147","GA","4547","GE","6147","Ga","6547","Ge","6847","Gh","6947","Gi","6C47","Gl","6E47","Gn","6F47","Go","7247","Gr","7547","Gu","7647","Gv","4144","DA","4544","DE","6144","Da","6544","De","6844","Dh","6944","Di","6F44","Do","7244","Dr","7544","Du","7644","Dv","4245","EB","4B45","EK","4A45","EJ","5045","EP","5345","ES","4645","EF","6145","Ea","6245","Eb","6745","Eg","6445","Ed","7A45","Ez","7945","Ey","6945","Ei","6B45","Ek","6C45","El","6D45","Em","6E45","En","6A45","Ej","6F45","Eo","7045","Ep","7245","Er","7345","Es","7445","Et","7545","Eu","6645","Ef","7845","Ex","6345","Ec","7645","Ev","415A","ZA","615A","Za","655A","Ze","685A","Zh","6F5A","Zo","765A","Zv","48","H","5348","HS","6748","Hg","6448","Hd","7948","Hy","6B48","Hk","6C48","Hl","6D48","Hm","6E48","Hn","6A48","Hj","7248","Hr","7348","Hs","7548","Hu","6348","Hc","4559","YE","5259","YR","6159","Ya","6559","Ye","6859","Yh","6959","Yi","6F59","Yo","7559","Yu","7659","Yv","4149","IA","4549","IE","4F49","IO","5649","IV","6149","Ia","6749","Ig","6449","Id","6549","Ie","6849","Ih","7949","Iy","6949","Ii","6B49","Ik","6C49","Il","6D49","Im","6E49","In","6F49","Io","7249","Ir","7349","Is","7449","It","7649","Iv","414B","KA","4F4B","KO","614B","Ka","654B","Ke","684B","Kh","694B","Ki","6C4B","Kl","6E4B","Kn","6F4B","Ko","724B","Kr","744B","Kt","754B","Ku","764B","Kv","454C","LE","4F4C","LO","614C","La","654C","Le","684C","Lh","694C","Li","6F4C","Lo","754C","Lu","764C","Lv","414D","MA","494D","MI","614D","Ma","654D","Me","684D","Mh","694D","Mi","6E4D","Mn","6F4D","Mo","754D","Mu","764D","Mv","414E","NA","614E","Na","654E","Ne","684E","Nh","694E","Ni","6F4E","No","754E","Nu","764E","Nv","654A","Je","4F","O","644F","Od","7A4F","Oz","794F","Oy","694F","Oi","6B4F","Ok","6C4F","Ol","6D4F","Om","6E4F","On","704F","Op","724F","Or","734F","Os","744F","Ot","754F","Ou","664F","Of","784F","Ox","634F","Oc","4550","PE","5250","PR","6150","Pa","6550","Pe","6850","Ph","6950","Pi","6C50","Pl","6E50","Pn","6F50","Po","7250","Pr","7450","Pt","7550","Pu","7650","Pv","4F52","RO","5652","RV","6152","Ra","6552","Re","6852","Rh","6952","Ri","6F52","Ro","7552","Ru","7652","Rv","4F53","SO","6153","Sa","6553","Se","6853","Sh","6953","Si","6B53","Sk","6D53","Sm","6F53","So","7053","Sp","7453","St","7553","Su","6653","Sf","7853","Sx","7653","Sv","4954","TI","5654","TV","6154","Ta","6554","Te","6854","Th","6954","Ti","6F54","To","7254","Tr","7554","Tu","7654","Tv","6755","Ug","6455","Ud","6955","Ui","6D55","Um","7055","Up","7355","Us","6355","Uc","4946","FI","6146","Fa","6546","Fe","6846","Fh","7946","Fy","6946","Fi","6C46","Fl","6F46","Fo","7246","Fr","7546","Fu","7646","Fv","6158","Xa","6558","Xe","6858","Xh","6958","Xi","6C58","Xl","6F58","Xo","7258","Xr","7658","Xv","6543","Ce","6F43","Co","7543","Cu","56","V","5356","VS","6256","Vb","6756","Vg","6456","Vd","6D56","Vm","6E56","Vn","6A56","Vj","7256","Vr","7356","Vs","6656","Vf","61","a","6261","ab","6761","ag","6461","ad","6561","ae","7A61","az","6861","ah","7961","ay","6961","ai","6B61","ak","6C61","al","6D61","am","6E61","an","6A61","aj","6F61","ao","7061","ap","7261","ar","7361","as","7461","at","7561","au","6661","af","7861","ax","6361","ac","7661","av","6162","ba","6462","bd","6562","be","6862","bh","6962","bi","6C62","bl","6F62","bo","7262","br","7562","bu","7662","bv","6167","ga","6567","ge","6867","gh","6967","gi","6C67","gl","6E67","gn","6F67","go","7267","gr","7567","gu","7667","gv","64","d","6164","da","6564","de","6864","dh","6964","di","6F64","do","7264","dr","7564","du","7664","dv","6165","ea","6265","eb","6765","eg","6465","ed","7A65","ez","7965","ey","6965","ei","6B65","ek","6C65","el","6D65","em","6E65","en","6A65","ej","6F65","eo","7065","ep","7265","er","7365","es","7465","et","7565","eu","6665","ef","7865","ex","6365","ec","7665","ev","657A","ze","687A","zh","697A","zi","6F7A","zo","757A","zu","767A","zv","68","h","6268","hb","6768","hg","6468","hd","7968","hy","6B68","hk","6C68","hl","6D68","hm","6E68","hn","6A68","hj","7068","hp","7268","hr","7368","hs","7468","ht","7568","hu","6668","hf","7868","hx","6368","hc","6179","ya","6579","ye","6879","yh","6979","yi","6C79","yl","6E79","yn","6F79","yo","7279","yr","7579","yu","7679","yv","6169","ia","6269","ib","6469","id","6569","ie","6B69","ik","6C69","il","6D69","im","6E69","in","6A69","ij","6F69","io","7069","ip","7269","ir","7369","is","7469","it","7869","ix","7669","iv","616B","ka","656B","ke","686B","kh","696B","ki","6C6B","kl","6E6B","kn","6F6B","ko","726B","kr","746B","kt","756B","ku","766B","kv","616C","la","656C","le","686C","lh","696C","li","6F6C","lo","756C","lu","766C","lv","616D","ma","656D","me","686D","mh","696D","mi","6E6D","mn","6F6D","mo","756D","mu","766D","mv","616E","na","656E","ne","686E","nh","696E","ni","6F6E","no","756E","nu","766E","nv","616A","ja","656A","je","686A","jh","756A","ju","6F","o","626F","ob","676F","og","646F","od","7A6F","oz","796F","oy","696F","oi","6B6F","ok","6C6F","ol","6D6F","om","6E6F","on","6A6F","oj","706F","op","726F","or","736F","os","746F","ot","756F","ou","666F","of","786F","ox","636F","oc","6170","pa","6570","pe","6870","ph","6970","pi","6C70","pl","6E70","pn","6F70","po","7270","pr","7470","pt","7570","pu","7670","pv","6172","ra","6572","re","6872","rh","6972","ri","6F72","ro","7572","ru","7672","rv","6173","sa","6273","sb","6573","se","6873","sh","7973","sy","6973","si","6B73","sk","6D73","sm","6F73","so","7073","sp","7473","st","7573","su","6673","sf","7873","sx","7673","sv","6174","ta","6574","te","6874","th","6974","ti","6D74","tm","6F74","to","7274","tr","7574","tu","7674","tv","6175","ua","6275","ub","6775","ug","6475","ud","6575","ue","6975","ui","6C75","ul","6D75","um","6E75","un","7075","up","7375","us","6675","uf","6375","uc","7675","uv","6166","fa","6566","fe","6866","fh","7966","fy","6966","fi","6C66","fl","6F66","fo","7266","fr","7566","fu","7666","fv","6178","xa","6578","xe","6878","xh","6978","xi","6C78","xl","6E78","xn","6F78","xo","7278","xr","7578","xu","7678","xv","6163","ca","6563","ce","6863","ch","6963","ci","6F63","co","7563","cu","7663","cv","76","v","6176","va","6476","vd","6576","ve","7A76","vz","6876","vh","6B76","vk","6C76","vl","6D76","vm","6E76","vn","6A76","vj","6F76","vo","7076","vp","7276","vr","7376","vs","7476","vt","6676","vf","7876","vx","7676","vv"];
    }

    static function getRuSimphony() {
        return ["E0","А","E0E0","АА","E0E2","АВ","E0E3","АГ","E0E4","АД","E0E5","АЕ","E0E7","АЗ","E0E8","АИ","E0E9","АЙ","E0EA","АК","E0EB","АЛ","E0EC","АМ","E0ED","АН","E0EE","АО","E0EF","АП","E0F0","АР","E0F1","АС","E0F2","АТ","E0F3","АУ","E0F4","АФ","E0F5","АХ","E1E0","БА","E1E5","БЕ","E1B8","БЁ","E1E8","БИ","E1EB","БЛ","E1EE","БО","E1F0","БР","E1F3","БУ","E1FA","БЪ","E1FB","БЫ","E1FC","БЬ","E2","В","E2E0","ВА","E2E1","ВБ","E2E2","ВВ","E2E3","ВГ","E2E4","ВД","E2E5","ВЕ","E2B8","ВЁ","E2E6","ВЖ","E2E7","ВЗ","E2E8","ВИ","E2EA","ВК","E2EB","ВЛ","E2EC","ВМ","E2ED","ВН","E2EE","ВО","E2EF","ВП","E2F0","ВР","E2F1","ВС","E2F2","ВТ","E2F3","ВУ","E2F5","ВХ","E2F7","ВЧ","E2FB","ВЫ","E2FC","ВЬ","E2FD","ВЭ","E2FF","ВЯ","E3E0","ГА","E3E2","ГВ","E3E4","ГД","E3E5","ГЕ","E3E8","ГИ","E3EB","ГЛ","E3ED","ГН","E3EE","ГО","E3F0","ГР","E3F3","ГУ","E3FD","ГЭ","E4E0","ДА","E4E2","ДВ","E4E5","ДЕ","E4E7","ДЗ","E4E8","ДИ","E4EB","ДЛ","E4ED","ДН","E4EE","ДО","E4F0","ДР","E4F3","ДУ","E4FB","ДЫ","E4FC","ДЬ","E4FD","ДЭ","E5E2","ЕВ","E5E3","ЕГ","E5E4","ЕД","E5B8","ЕЁ","E5E6","ЕЖ","E5E7","ЕЗ","E5E8","ЕИ","E5E9","ЕЙ","E5EA","ЕК","E5EB","ЕЛ","E5EC","ЕМ","E5ED","ЕН","E5EF","ЕП","E5F0","ЕР","E5F1","ЕС","E5F2","ЕТ","E5F4","ЕФ","E5F8","ЕШ","E5F9","ЕЩ","E5FE","ЕЮ","B8E6","ЁЖ","E6E0","ЖА","E6E2","ЖВ","E6E3","ЖГ","E6E4","ЖД","E6E5","ЖЕ","E6B8","ЖЁ","E6E8","ЖИ","E6ED","ЖН","E6F0","ЖР","E6F3","ЖУ","E7E0","ЗА","E7E2","ЗВ","E7E4","ЗД","E7E5","ЗЕ","E7B8","ЗЁ","E7E8","ЗИ","E7EB","ЗЛ","E7EC","ЗМ","E7ED","ЗН","E7EE","ЗО","E7F0","ЗР","E7F3","ЗУ","E7FF","ЗЯ","E8","И","E8E0","ИА","E8E1","ИБ","E8E2","ИВ","E8E3","ИГ","E8E4","ИД","E8E5","ИЕ","E8E7","ИЗ","E8E8","ИИ","E8EA","ИК","E8EB","ИЛ","E8EC","ИМ","E8ED","ИН","E8EE","ИО","E8EF","ИП","E8F0","ИР","E8F1","ИС","E8F2","ИТ","E8F3","ИУ","E8F4","ИФ","E8F5","ИХ","E8F9","ИЩ","E8FD","ИЭ","EA","К","EAE0","КА","EAE2","КВ","EAE5","КЕ","EAE8","КИ","EAEB","КЛ","EAED","КН","EAEE","КО","EAF0","КР","EAF1","КС","EAF2","КТ","EAF3","КУ","EAFD","КЭ","EBE0","ЛА","EBE1","ЛБ","EBE3","ЛГ","EBE5","ЛЕ","EBB8","ЛЁ","EBE6","ЛЖ","EBE8","ЛИ","EBEE","ЛО","EBF3","ЛУ","EBFB","ЛЫ","EBFC","ЛЬ","EBFD","ЛЭ","EBFE","ЛЮ","EBFF","ЛЯ","ECE0","МА","ECE3","МГ","ECE5","МЕ","ECB8","МЁ","ECE8","МИ","ECEB","МЛ","ECED","МН","ECEE","МО","ECF0","МР","ECF1","МС","ECF3","МУ","ECF9","МЩ","ECFB","МЫ","ECFD","МЭ","ECFF","МЯ","EDE0","НА","EDE5","НЕ","EDB8","НЁ","EDE8","НИ","EDEE","НО","EDF0","НР","EDF3","НУ","EDFB","НЫ","EDFD","НЭ","EDFF","НЯ","EE","О","EEE1","ОБ","EEE2","ОВ","EEE3","ОГ","EEE4","ОД","EEE6","ОЖ","EEE7","ОЗ","EEEA","ОК","EEEB","ОЛ","EEEC","ОМ","EEED","ОН","EEEF","ОП","EEF0","ОР","EEF1","ОС","EEF2","ОТ","EEF4","ОФ","EEF5","ОХ","EEF6","ОЦ","EEF7","ОЧ","EEF8","ОШ","EEF9","ОЩ","EFE0","ПА","EFE5","ПЕ","EFB8","ПЁ","EFE8","ПИ","EFEB","ПЛ","EFEE","ПО","EFF0","ПР","EFF1","ПС","EFF2","ПТ","EFF3","ПУ","EFF7","ПЧ","EFF8","ПШ","EFFB","ПЫ","EFFC","ПЬ","EFFF","ПЯ","F0E0","РА","F0E2","РВ","F0E5","РЕ","F0B8","РЁ","F0E6","РЖ","F0E8","РИ","F0EE","РО","F0F2","РТ","F0F3","РУ","F0FB","РЫ","F0FD","РЭ","F0FF","РЯ","F1","С","F1E0","СА","F1E1","СБ","F1E2","СВ","F1E3","СГ","F1E4","СД","F1E5","СЕ","F1B8","СЁ","F1E6","СЖ","F1E7","СЗ","F1E8","СИ","F1EA","СК","F1EB","СЛ","F1EC","СМ","F1ED","СН","F1EE","СО","F1EF","СП","F1F0","СР","F1F1","СС","F1F2","СТ","F1F3","СУ","F1F4","СФ","F1F5","СХ","F1F7","СЧ","F1F8","СШ","F1FA","СЪ","F1FB","СЫ","F1FD","СЭ","F1FE","СЮ","F1FF","СЯ","F2E0","ТА","F2E2","ТВ","F2E5","ТЕ","F2B8","ТЁ","F2E8","ТИ","F2EA","ТК","F2EB","ТЛ","F2EC","ТМ","F2EE","ТО","F2F0","ТР","F2F3","ТУ","F2F9","ТЩ","F2FB","ТЫ","F2FC","ТЬ","F2FD","ТЭ","F2FE","ТЮ","F2FF","ТЯ","F3","У","F3E1","УБ","F3E2","УВ","F3E3","УГ","F3E4","УД","F3E6","УЖ","F3E7","УЗ","F3E8","УИ","F3E9","УЙ","F3EA","УК","F3EB","УЛ","F3EC","УМ","F3ED","УН","F3EF","УП","F3F0","УР","F3F1","УС","F3F2","УТ","F3F4","УФ","F3F5","УХ","F3F6","УЦ","F3F7","УЧ","F3F8","УШ","F3F9","УЩ","F3FF","УЯ","F4E0","ФА","F4E5","ФЕ","F4E8","ФИ","F4EB","ФЛ","F4EE","ФО","F4F0","ФР","F4F3","ФУ","F4FD","ФЭ","F5E0","ХА","F5E2","ХВ","F5E5","ХЕ","F5E8","ХИ","F5EB","ХЛ","F5EC","ХМ","F5EE","ХО","F5F0","ХР","F5F3","ХУ","F5FD","ХЭ","F6E0","ЦА","F6E2","ЦВ","F6E5","ЦЕ","F7E0","ЧА","F7E5","ЧЕ","F7B8","ЧЁ","F7E8","ЧИ","F7EB","ЧЛ","F7F0","ЧР","F7F2","ЧТ","F7F3","ЧУ","F8E0","ША","F8E2","ШВ","F8E5","ШЕ","F8B8","ШЁ","F8E8","ШИ","F8EA","ШК","F8EB","ШЛ","F8F2","ШТ","F8F3","ШУ","F9E0","ЩА","F9E5","ЩЕ","F9B8","ЩЁ","F9E8","ЩИ","F9F3","ЩУ","FDE2","ЭВ","FDE3","ЭГ","FDE4","ЭД","FDE7","ЭЗ","FDE8","ЭИ","FDEA","ЭК","FDEB","ЭЛ","FDEC","ЭМ","FDED","ЭН","FDEF","ЭП","FDF0","ЭР","FDF1","ЭС","FDF2","ЭТ","FDF4","ЭФ","FDF5","ЭХ","FDFF","ЭЯ","FEE3","ЮГ","FEE6","ЮЖ","FEED","ЮН","FF","Я","FFE1","ЯБ","FFE2","ЯВ","FFE3","ЯГ","FFE4","ЯД","FFE7","ЯЗ","FFE8","ЯИ","FFE9","ЯЙ","FFEA","ЯК","FFEC","ЯМ","FFED","ЯН","FFF0","ЯР","FFF1","ЯС","FFF7","ЯЧ","FFF8","ЯШ","FFF9","ЯЩ"];
    }

    static function getGreekSimphonyWord() {
        return ["6100","a","6161","aa","6162","ab","6167","ag","6164","ad","6165","ae","617A","az","6168","ah","6179","ay","6169","ai","616B","ak","616C","al","616D","am","616E","an","616A","aj","616F","ao","6170","ap","6172","ar","6173","as","6174","at","6175","au","6166","af","6178","ax","6163","ac","6176","av","6261","ba","6264","bd","6265","be","6268","bh","6269","bi","626C","bl","626F","bo","6272","br","6275","bu","6276","bv","6761","ga","6765","ge","6768","gh","6769","gi","676C","gl","676E","gn","676F","go","6772","gr","6775","gu","6776","gv","6461","da","6465","de","6468","dh","6469","di","646F","do","6472","dr","6475","du","6476","dv","6561","ea","6562","eb","6567","eg","6564","ed","657A","ez","6579","ey","6569","ei","656B","ek","656C","el","656D","em","656E","en","656A","ej","656F","eo","6570","ep","6572","er","6573","es","6574","et","6575","eu","6566","ef","6578","ex","6563","ec","6576","ev","7A61","za","7A65","ze","7A68","zh","7A69","zi","7A6F","zo","7A75","zu","7A76","zv","6800","h","6867","hg","6864","hd","6879","hy","686B","hk","686C","hl","686D","hm","686E","hn","6870","hp","6872","hr","6873","hs","6874","ht","6875","hu","6878","hx","7961","ya","7965","ye","7968","yh","7969","yi","796C","yl","796E","yn","796F","yo","7972","yr","7975","yu","7976","yv","6961","ia","6962","ib","6967","ig","6964","id","6965","ie","6968","ih","6979","iy","6969","ii","696B","ik","696C","il","696D","im","696E","in","696A","ij","696F","io","6970","ip","6972","ir","6973","is","6974","it","6978","ix","6976","iv","6B61","ka","6B65","ke","6B68","kh","6B69","ki","6B6C","kl","6B6E","kn","6B6F","ko","6B72","kr","6B74","kt","6B75","ku","6B76","kv","6C61","la","6C65","le","6C68","lh","6C69","li","6C6F","lo","6C75","lu","6C76","lv","6D61","ma","6D65","me","6D68","mh","6D69","mi","6D6E","mn","6D6F","mo","6D75","mu","6D76","mv","6E61","na","6E65","ne","6E68","nh","6E69","ni","6E6F","no","6E75","nu","6E76","nv","6A61","ja","6A65","je","6A68","jh","6A75","ju","6F00","o","6F62","ob","6F67","og","6F64","od","6F7A","oz","6F79","oy","6F69","oi","6F6B","ok","6F6C","ol","6F6D","om","6F6E","on","6F6A","oj","6F70","op","6F72","or","6F73","os","6F74","ot","6F75","ou","6F66","of","6F78","ox","6F63","oc","7061","pa","7065","pe","7068","ph","7069","pi","706C","pl","706E","pn","706F","po","7072","pr","7074","pt","7075","pu","7076","pv","7261","ra","7265","re","7268","rh","7269","ri","726F","ro","7275","ru","7276","rv","7361","sa","7362","sb","7365","se","7368","sh","7379","sy","7369","si","736B","sk","736D","sm","736F","so","7370","sp","7374","st","7375","su","7366","sf","7378","sx","7376","sv","7461","ta","7465","te","7468","th","7469","ti","746D","tm","746F","to","7472","tr","7475","tu","7476","tv","7561","ua","7562","ub","7567","ug","7564","ud","7565","ue","7569","ui","756C","ul","756D","um","756E","un","7570","up","7573","us","7566","uf","7563","uc","7576","uv","6661","fa","6665","fe","6668","fh","6679","fy","6669","fi","666C","fl","666F","fo","6672","fr","6675","fu","6676","fv","7861","xa","7865","xe","7868","xh","7869","xi","786C","xl","786E","xn","786F","xo","7872","xr","7875","xu","7876","xv","6361","ca","6365","ce","6368","ch","6369","ci","636F","co","6375","cu","6376","cv","7600","v","7661","va","7662","vb","7667","vg","7664","vd","7665","ve","7679","vy","766D","vm","766E","vn","766A","vj","766F","vo","7672","vr","7673","vs","7674","vt","7666","vf","7678","vx"];
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
        $BOOK_FULL_NAMES_GREEK = [
            'Бытие', 'Исход', 'Левит', 'Числа','Второзаконие', '', '', 'Руфи', '', '', '', '', '', '',
            'Ездры', '', '', 'Товита', 'Иудифи',
            'Есфирь', '', '', '', 'Екклесиаст', 'Песнь Песней', '', '', 'Исаии', '', 'Плач Иеремии', 'Послание Иеремии',
            'Варуха', 'Варуха', 'Даниила (Ф)', /*'Дан',*/ 'Осии',
            'Иоиля', 'Амоса', 'Авдия', 'Ионы', 'Михея', 'Наума', 'Аввакума', 'Софонии', 'Аггея','Захарии',
            'Малахии', '', '', '', '', 'Матфея', 'Марка', 'Луки', 'Иоанна', 'Деяния', 'Иакова', '1 Петра', '2 Петра', '1 Иоанна',
            '2 Иоанна','3 Иоанна', 'Иуды', 'Римлянам', '1 Коринфянам', '2 Коринфянам', 'Галатам', 'Ефесянам', 'Филиппийцам', 'Колоссянам',
            '1 Фессалоникийцам','2 Фессалоникийцам', '1 Тимофею','2 Тимофею', 'Титу','Филимону', 'Евреям','Откровение', 'Даниила'
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
        $BOOK_FULL_NAMES_RU = [
            'Бытие', 'Исход', 'Левит', 'Числа','Второзаконие', 'Иисус Навин', 'Книга Судей','Руфь', '1-я Царств','2-я Царств', '3-я Царств','4-я Царств',
            '1-я Паралипоменон','2-я Паралипоменон', 'Ездра','Неемия', '2 кн. Ездры','Товит', 'Иудифь','Есфирь', 'Иов','Псалтирь', 'Притчи',
            'Екклесиаст', 'Песнь Песней', 'Премудрость Соломона','Сирах', 'Исаия','Иеремия', 'Плач Иеремии','Послание Иеремии',
            'Варух','Иезекииль', 'Даниил','Осия', 'Иоиль','Амос', 'Авдий','Иона', 'Михей','Наум', 'Аввакум',
            'Софония', 'Аггей','Захария', 'Малахия', '1 кн. Маккавейская', '2 кн. Маккавейская', '3 кн. Маккавейская', '3 кн. Ездры',
            'От Матфея', 'От Марка','От Луки', 'От Иоанна','Деяния', 'Иакова','1-е Петра', '2-е Петра',
            '1-е Иоанна', '2-е Иоанна','3-е Иоанна', 'Иуда','К Римлянам', '1-е Коринфянам','2-е Коринфянам', 'К Галатам','К Ефесянам', 'К Филиппийцам',
            'К Колоссянам', '1-е Фессалоникийцам','2-е Фессалоникийцам', '1-е Тимофею','2-е Тимофею', 'К Титу','К Филимону', 'К Евреям','Откровение'
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
            'BOOK_FULL_NAMES_GREEK' => $BOOK_FULL_NAMES_GREEK,
            'BOOK_NAMES_RU'         => $BOOK_NAMES_RU,
            'BOOK_FULL_NAMES_RU'    => $BOOK_FULL_NAMES_RU,
            'COUNT_CHAPTER_BOOKS'   => $COUNT_CHAPTER_BOOKS
        ];
    }

}