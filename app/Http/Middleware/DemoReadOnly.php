<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class DemoReadOnly
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! config('crm.demo.enabled') || $request->isMethodSafe()) {
            return $next($request);
        }

        $apiPrefix = trim((string) config('crm.api.prefix'), '/');
        $path = trim($request->path(), '/');
        $resource = str_starts_with($path, $apiPrefix.'/')
            ? explode('/', substr($path, strlen($apiPrefix) + 1), 2)[0]
            : null;

        if ($resource !== null && config("crm.demo.writes.{$resource}", false)) {
            return $next($request);
        }

        return new JsonResponse([
            'message' => 'Não foi possível concluir esta ação.',
        ], Response::HTTP_FORBIDDEN);
    }
}
