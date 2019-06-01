<?php

namespace Tests;

use App\Library\Router;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\Request;

class RouterTest extends TestCase
{

    /** @test */
    public function it_can_be_instantiated()
    {
        $router = new Router(Request::create('/'));

        $this->assertInstanceOf(Router::class, $router);
    }

}
