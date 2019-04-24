<?php
/**
 * Created by IntelliJ IDEA.
 * User: mchristlieb
 * Date: 03.12.17
 * Time: 16:55
 */

namespace App\Controller;


use Twig\Environment;
use Twig\Loader\FilesystemLoader;

/**
 * Class Controller
 * @package App\Controller
 */
abstract class Controller
{
    /**
     * @var \Twig_Environment
     */
    protected $twig;
    
    /**
     * Controller constructor.
     */
    public function __construct()
    {
        $loader = new FilesystemLoader(VIEW_DIR);
        $this->twig = new Environment($loader);
    }
    
    /**
     * Redirects to another url
     *
     * @param $url string
     */
    protected function redirect($url)
    {
        header('Location: ' . $url, true, 302);
        exit();
    }
}
