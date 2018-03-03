<?php
/**
 * Created by IntelliJ IDEA.
 * User: mchristlieb
 * Date: 05.12.17
 * Time: 18:23
 */

namespace App\Controller;

use App\Model\Post;

class PostsController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        
        echo $this->twig->render('posts/index.twig', compact('posts'));
    }
    
    public function single($id)
    {
        $post = Post::findById($id);
        echo $this->twig->render('posts/single.twig', compact('post'));
        
    }
}
