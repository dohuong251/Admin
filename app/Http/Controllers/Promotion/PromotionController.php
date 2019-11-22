<?php

namespace App\Http\Controllers\Promotion;

use App\Http\Controllers\model;
use DB;
use DOMDocument;
use DOMXPath;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use PDO;

class PromotionController extends Controller
{
    public function index()
    {
        DB::connection('mysql_lsp_connection')->getPdo()->setAttribute(PDO::MYSQL_ATTR_USE_BUFFERED_QUERY, false);
        dd(DB::connection('mysql_lsp_connection')->getPdo());
        $doc = new DOMDocument();
        $doc->validateOnParse = true;
        $doc->loadHTML(htmlentities(file_get_contents('E:\MDCAdmin\Note\layout.php')));

//        $doc->Load('E:\MDCAdmin\Note\layout.php');
//        dd($doc);
        $finder = new DomXPath($doc);
        $classname="footer";
        $nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
        dd($doc->getElementById('footer'));
        dd($doc->saveHTML());
        return view('promotions.index');
    }
    //

    /**
     * @return array các tham số share cho tất cả các view trả về bởi controller
     */
    protected function getViewShareArray()
    {
        // TODO: Implement getViewShareArray() method.
    }

    /**
     * @return model sẽ thực hiện xóa hàng loạt trong hàm delete
     */
    protected function getDeleteClass()
    {
        // TODO: Implement getDeleteClass() method.
    }
}
