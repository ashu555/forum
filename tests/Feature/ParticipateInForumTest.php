<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ParticipateInForum extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_an_authenticated_user_can_participate_in_form_threads()
    {
        $this->be($user = create('App\User'));
        
        $thread = create('App\Thread');

        $reply = make('App\Reply');
        $this->post($thread->path().'/replies', $reply->toArray());
        $this->get($thread->path())
        ->assertSee($reply->body);
    }

    public function test_unauthenticated_user_cannot_add_replies()
    {
        $this->withExceptionHandling()
        ->post('/threads/channel/1/replies', [])
        ->assertRedirect('/login');
       
    }

    function test_a_reply_requires_a_body()
    {
        $this->withExceptionHandling()->signIn();
        $thread = create('App\Thread');

        $reply = make('App\Reply', ['body'=>null]);
        $this->post($thread->path().'/replies', $reply->toArray())
        ->assertSessionHasErrors('body');
    }
}
