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
        $handler = new SLCLEventHandler();

        $handler->subscribe($app->events);
    }
}
