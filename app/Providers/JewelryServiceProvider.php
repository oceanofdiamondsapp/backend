<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class JewelryServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind('Jewelry', function()
		{
			return new \OOD\Jewelry\Jewelry;
		});
	}

}
