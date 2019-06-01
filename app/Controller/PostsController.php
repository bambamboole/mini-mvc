<?php
/**
 * Created by IntelliJ IDEA.
 * User: mchristlieb
 * Date: 05.12.17
 * Time: 18:23
 */

namespace App\Controller;

use App\Model\Post;
use Symfony\Component\HttpFoundation\Response;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::all();

        return Response::create($this->twig->render('posts/index.twig', compact('posts')));
    }

    public function single($id)
    {
        $post = Post::findById($id);

        return Response::create($this->twig->render('posts/single.twig', compact('post')));
    }
}
