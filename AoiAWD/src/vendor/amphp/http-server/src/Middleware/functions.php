<?php

namespace Amp\Http\Server\Middleware;

use Amp\Http\Server\Middleware;
use Amp\Http\Server\Middleware\Internal\MiddlewareRequestHandler;
use Amp\Http\Server\RequestHandler;

/**
 * Wraps a request handler with the given set of middlewares.
 *
 * @param RequestHandler $requestHandler Request handler to wrap.
 * @param Middleware[]   $middlewares Middlewares to apply; order determines the order of application.
 *
 * @return RequestHandler Wrapped request handler.
 */
function stack(RequestHandler $requestHandler, Middleware ...$middlewares) {
    if (!$middlewares) {
        return $requestHandler;
    }

    $middleware = \end($middlewares);

    while ($middleware) {
        $requestHandler = new MiddlewareRequestHandler($middleware, $requestHandler);
        $middleware = \prev($middlewares);
    }

    return $requestHandler;
}
