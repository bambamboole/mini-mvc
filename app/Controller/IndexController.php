<?php
/**
 * Created by IntelliJ IDEA.
 * User: mchristlieb
 * Date: 03.12.17
 * Time: 16:34
 */

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class IndexController extends Controller
{
    public function index()
    {
        return Response::create($this->twig->render('index.twig', ['name' => 'World']));
    }
}
