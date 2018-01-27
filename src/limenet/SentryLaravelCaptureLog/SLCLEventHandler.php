<?php

namespace Sentry\SentryLaravel;

use Exception;
use Raven_Client;
use Illuminate\Routing\Route;
use Illuminate\Events\Dispatcher;
use Illuminate\Log\Events\MessageLogged;
use Illuminate\Auth\Events\Authenticated;
use Illuminate\Routing\Events\RouteMatched;
use Illuminate\Database\Events\QueryExecuted;

class SLCLEventHandler
{
    /**
     * Attach all event handlers.
     *
     * @param \Illuminate\Events\Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen('Illuminate\Log\Events\MessageLogged', array($this, 'messageLogged'));
    }

    /**
     * Since Laravel 5.4
     *
     * @param \Illuminate\Log\Events\MessageLogged $logEntry
     */
    protected function messageLogged(MessageLogged $logEntry)
    {
        $level = $logEntry->level;
            $message = $logEntry->message;
            $context = $logEntry->context;

            if ($level === 'debug') {
                return;
            }

            if (array_key_exists('exception', $context)) {
                if ($context['exception']instanceof \Throwable) {
                    return;
                }
            }

            $context['level'] = $level;

            app('sentry')->captureMessage($message, [], $context);
    }

}
