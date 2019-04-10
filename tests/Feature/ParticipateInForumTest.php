<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateInForum extends TestCase
{
    // use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_an_authenticated_user_can_participate_in_form_threads()
    {
        $this->be($user = create('App\User'));
        
        $thread = create('App\Thread');

        $reply = create('App\Reply');
        $this->post($thread->path().'/replies', $reply->toArray());
        $this->get($thread->path())
        ->assertSee($reply->body);
    }

    // public function test_unauthenticated_user_cannot_add_replies()
    // {
    //     $this->expectException('\Illuminate\Auth\AuthenticationException');
    //     $this->post('/threads/1/replies', []);
       
    // }
}
