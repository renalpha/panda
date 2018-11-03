<?php

namespace Tests\Unit;

use Tests\TestCase;

class PandaUserTest extends TestCase
{
    public function testLogin()
    {
        $response = $this->get('/login');
        $this->assertTrue($response->status() === 200);
    }

    public function testRegister()
    {
        $response = $this->get('/register');
        $this->assertTrue($response->status() === 200);
    }
}
