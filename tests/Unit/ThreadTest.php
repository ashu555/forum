<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ThreadTest extends TestCase
{
	use DatabaseMigrations;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    protected $thread;

    public function setUp(): void
    {
        parent::setUp();

        $this->thread = factory('App\Thread')->create();
    }

    public function test_a_thread_can_make_a_string_path()
    {
        $thread = create('App\Thread');
        $this->assertEquals(url('/threads/'.$thread->channel->slug. '/'. $thread->id), $thread->path()); 
    }

    public function test_a_thread_has_creator()
    {
        $this->assertInstanceOf('App\User', $this->thread->creator);
    }

    public function test_a_thread_has_replies()
    {
       $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->thread->replies);
    }


    public function test_a_thread_can_add_a_reply()
    {
    	$this->thread->addReply([
    		'body'=>'foobar',
    		'user_id'=>1,
    	]);
    	$this->assertCount(1, $this->thread->replies);
    }

    function test_a_thread_belongs_to_a_channel()
    {
        $thread = create('App\Thread');
        $this->assertInstanceOf('App\Channel',$thread->channel);
    }
}
