<?php

namespace ITCity\Rivile;

use Illuminate\Support\ServiceProvider;

class RivileServiceProvider extends ServiceProvider {
	public function register()
    {
        $this->app->alias('Rivile', Rivile::class);
    }
}