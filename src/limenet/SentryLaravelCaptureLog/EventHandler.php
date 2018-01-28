<?php

namespace limenet\SentryLaravelCaptureLog;

use Exception;
use Illuminate\Events\Dispatcher;
use Illuminate\Log\Events\MessageLogged;

class EventHandler
{
    public function subscribe(Dispatcher $events)
    {
        $events->listen(MessageLogged::class, [$this, 'logEntry']);
    }

    public function logEntry(MessageLogged $logEntry)
    {
        $level = $logEntry->level;
        $message = $logEntry->message;
        $context = $logEntry->context;

        if ($level === 'debug') {
            return;
        }

        if (is_array($context) && array_key_exists('exception', $context)) {
            if ($context['exception'] instanceof \Throwable) {
                return;
            }
        }

        if (is_object($context) && property_exists($context, 'exception')) {
            if ($context->exception instanceof \Throwable) {
                return;
            }
        }

        $context['level'] = $level;

        app('sentry')->captureMessage($message, [], $context);
    }
}
