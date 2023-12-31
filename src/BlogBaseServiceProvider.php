<?php

namespace Djohnnyboy\Poweredblog;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use Djohnnyboy\Poweredblog\Facades\Blog;

class BlogBaseServiceProvider extends ServiceProvider {
	
	public function boot(){

		if ($this->app->runningInConsole()) {
			$this->registerPublishing();
		}
		$this->registerResources();
	}

	public function register(){

		$this->commands([
			Console\ProcessCommand::class,
		]);	
	}

	private function registerResources(){
		
		$this->loadMigrationsFrom(__DIR__.'/../database/migrations');
		$this->loadViewsFrom(__DIR__.'/../resources/views', 'blog');
		$this->registerFacades();
		$this->registerRoutes();
		$this->registerFields();		
	}

	protected function registerPublishing(){

		$this->publishes([
			__DIR__.'/../config/blog.php' => config_path('blog.php'),
		], 'blog-config');

		$this->publishes([
			__DIR__.'/Console/stubs/BlogServiceProvider.stub' => app_path('Providers/BlogServiceProvider.php'),
		], 'blog-provider');
	}

	protected function registerRoutes(){

		Route::group($this->routeConfiguration(), function() {
			$this->loadRoutesFrom(__DIR__.'/../routes/web.php');
		});
	}

	private function routeConfiguration(){

		return [
			//'prefix' => config('blog.path', 'blogs'),
			'prefix' => Blog::path(),
			'namespace' => 'Djohnnyboy\Poweredblog\Http\Controllers',
		];
	}

	protected function registerFacades(){

		$this->app->singleton('Blog', function($app){
			return new \Djohnnyboy\Poweredblog\Blog();
		});
	}

	private function registerFields(){
		
		Blog::fields([
			Fields\Body::class,
			Fields\Date::class,
			Fields\Description::class,
			Fields\Extra::class,
			Fields\Title::class,
		]);
	}
}