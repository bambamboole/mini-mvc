<?php
/**
 * Created by IntelliJ IDEA.
 * User: mchristlieb
 * Date: 03.12.17
 * Time: 16:55
 */

namespace App\Controller;


use Symfony\Component\HttpFoundation\Request;
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
     * @var Request
     */
    protected $request;

    /**
     * Controller constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $loader = new FilesystemLoader(VIEW_DIR);
        $this->twig = new Environment($loader);
        $this->request = $request;
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
