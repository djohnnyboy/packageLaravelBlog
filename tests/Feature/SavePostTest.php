<?php

namespace Djohnnyboy\Poweredblog\Tests;

use Djohnnyboy\Poweredblog\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SavePostTest extends TestCase {

	use RefreshDatabase;
	/** @test */
	public function post_created_factories(){

		$post = factory(Post::class)->create();
		$this->assertCount(1, Post::all());
	}
}