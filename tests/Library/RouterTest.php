<?php

namespace Tests;

use App\Library\Router;
use PHPUnit\Framework\TestCase;

class RouterTest extends TestCase
{
    protected function setUp(): void
    {
        // Default request uri
        $_SERVER['REQUEST_URI'] = '/';
    }

    /** @test */
    public function it_can_be_instantiated()
    {
        $router = new Router();

        $this->assertInstanceOf(Router::class, $router);
    }

}
