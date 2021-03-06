<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadsTest extends TestCase
{
    // use DatabaseMigrations;

    public function test_guests_cannot_create_new_forum_threads()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $thread = make('App\Thread');
        $this->post('/threads',$thread->toArray());
    }
    /**
    test
     */
    public function test_an_authenticated_user_can_create_new_forum_threads()
    {
        $this->signIn();
        
        $thread = make('App\Thread');;
        $this->post('/threads',$thread->toArray());
        $this->get($thread->path())
             ->assertSee($thread->title)
             ->assertSee($thread->body);
    }
}
