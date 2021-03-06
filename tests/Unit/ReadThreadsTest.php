<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReadThreadsTest extends TestCase
{
    // use DatabaseMigrations;

    public function setUp(): void
    {
        parent::setUp();

        $this->thread = create('App\Thread');
    }

    /** @group view thread */
    public function test_a_user_can_view_all_threads()
    {
        $response = $this->get('/threads')
        ->assertSee($this->thread->title);

      
    }
    
    /** @group view thread */
    public function test_a_user_can_read_a_single_thread()
    {
    	 $response = $this->get($this->thread->path())
         ->assertSee($this->thread->title);
    }
    
    /** @group view thread */
    function test_a_user_can_read_replies_that_are_associated_with_a_test()
    {
        $reply = factory('App\Reply')->create(['thread_id'=>$this->thread->id]);

        $this->get($this->thread->path())
        ->assertSee($reply->body);
    }
}
