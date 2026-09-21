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

        $contactsPath = trim((string) config('crm.api.prefix'), '/').'/contacts';

        if ($request->isMethod('POST') && trim($request->path(), '/') === $contactsPath) {
            return $next($request);
        }

        return new JsonResponse([
            'message' => 'Esta ação está disponível somente após a contratação do sistema.',
        ], Response::HTTP_FORBIDDEN);
    }
}
