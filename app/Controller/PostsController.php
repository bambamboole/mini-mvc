<?php
/**
 * Created by IntelliJ IDEA.
 * User: mchristlieb
 * Date: 05.12.17
 * Time: 18:23
 */

namespace App\Controller;


use App\Library\Config;
use App\Model\Post;

class PostsController extends Controller {

    public function index() {
        $posts = Post::all();
        var_dump($posts);
    }

    public function single($id) {
        $post = Post::findById($id);
        var_dump($post);
    }
}
