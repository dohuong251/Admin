<?php

namespace App\Http\Controllers\Promotion;

use App\Http\Controllers\model;
use DOMDocument;
use DOMXPath;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PromotionController extends Controller
{
    public function index()
    {
        $doc = new DOMDocument();
        $doc->loadHTML('E:\MDCAdmin\Note\layout.php');
        $finder = new DomXPath($doc);
        $classname="footer";
        $nodes = $finder->query("//*[contains(concat(' ', normalize-space(@class), ' '), ' $classname ')]");
        dd($nodes);
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
