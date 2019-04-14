<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class CreateThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function test_guests_cannot_create_new_forum_threads()
    {
        $this->withExceptionHandling()
        ->get('threads/create')
        ->assertRedirect('login');

        $this->post('/threads')
        ->assertRedirect('/login');
    }

    /**
    test
     */
   

    public function test_an_authenticated_user_can_create_new_forum_threads()
    {
        $this->signIn();
        
        $thread = make('App\Thread');;
        $response = $this->post('/threads',$thread->toArray());

        $this->get($response->headers->get('Location'))
             ->assertSee($thread->title)
             ->assertSee($thread->body);
    }

    function test_a_thread_requires_a_title()
    {
       $this->publishThreads(['title'=>null])
       ->assertSessionHasErrors('title');
    }

    function test_a_thread_requires_a_body()
    {
       $this->publishThreads(['body'=>null])
       ->assertSessionHasErrors('body');
    }

    function test_a_thread_requires_a_valid_channel()
    {
        factory('App\Channel',3)->create();
        $this->publishThreads(['channel_id'=>null])
       ->assertSessionHasErrors('channel_id');

        $this->publishThreads(['channel_id'=>99])
       ->assertSessionHasErrors('channel_id');

    }

    public function publishThreads($overrides= [])
    {
         $this->withExceptionHandling()->signIn();

        $thread = make('App\Thread',$overrides);
        return $this->post('/threads',$thread->toArray());
        
    }
}
