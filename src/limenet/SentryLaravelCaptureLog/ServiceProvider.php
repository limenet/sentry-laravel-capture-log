<?php

namespace limenet\SentryLaravelCaptureLog;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;

class ServiceProvider extends BaseServiceProvider
{
    public function boot()
    {
        $app = $this->app;
        $this->bindEvents($app);
    }

    protected function bindEvents($app)
    {
        $handler = new EventHandler();

        $handler->subscribe($app->events);
    }
}
