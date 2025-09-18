<?php

namespace Tests\App\Http\Controllers;

use App\Http\Controllers\System\UserController;
use App\Services\System\UserService;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function test_index(): void
    {
        $service = new UserService();
        $controller = new UserController();
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
