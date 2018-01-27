<?php

namespace Sentry\SentryLaravel;

use Illuminate\Support\ServiceProvider;

class SLCLServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $app = $this->app;
        $this->bindEvents($app);
    }

    /**
     * Bind to the Laravel event dispatcher to log events.
     *
     * @param $app
     */
    protected function bindEvents($app)
    {
        $handler = new SLCLEventHandler();

        $handler->subscribe($app->events);
    }
}
