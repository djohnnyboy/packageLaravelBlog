<?php

namespace Djohnnyboy\Poweredblog\Console;

use Djohnnyboy\Poweredblog\Post;
use Djohnnyboy\Poweredblog\Repositories\PostRepository;
use Illuminate\Console\Command;
use Djohnnyboy\Poweredblog\Facades\Blog;

class ProcessCommand extends Command {

	protected $signature = 'blog:process';
	protected $description = 'updates blog posts.';

	public function handle(PostRepository $postRepository){
		
		if (Blog::configNotPublished()) {

			return $this->warn('Please publish the config file run \' php artisan vendor:publish --tag=blog-config\' ');
		}

		try{

			$posts = Blog::driver()->fetchPosts();
			$this->info('Number of repositories= ' . count($posts));

				foreach ($posts as $post) {
					if ($post != null) {
						$postRepository->save($post);
					}	
				}
			} catch (\Exception $e){
				$this->error($e->getMessage());
		}				
	}
	
}