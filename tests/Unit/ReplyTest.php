<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReplyTest extends TestCase
{
	// use DatabaseMigrations;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_it_has_an_owner()
    {
        
        $reply = factory('App\Reply')->create();
        $this->assertInstanceof('App\User', $reply->owner);

    }
}
