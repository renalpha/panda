<?php

namespace Tests\Unit;

use Domain\Entities\PandaUser\PandaUser;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PandaGroupTest extends TestCase
{
    public function testCreateGroup()
    {
        $user = factory(PandaUser::class)->create();

        $this->be($user);

        $response = $this->get('/group/new');

        $this->assertTrue($response->getStatusCode() === 200);

    }
}
