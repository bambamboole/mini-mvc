<?php
/**
 * Created by IntelliJ IDEA.
 * User: mchristlieb
 * Date: 03.12.17
 * Time: 16:55
 */

namespace App\Controller;


use App\Library\View;

/**
 * Class Controller
 * @package App\Controller
 */
abstract class Controller {

    /**
     * @var View
     */
    protected $view;

    /**
     * Controller constructor.
     */
    public function __construct() {
        $this->view = new View();
    }

    /**
     * Redirects to another url
     *
     * @param $url string
     */
    protected function redirect($url) {
        header('Location: ' . $url, true,  302);
        exit();
    }
}
