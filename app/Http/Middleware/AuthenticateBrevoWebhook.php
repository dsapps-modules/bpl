<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateBrevoWebhook
{
    public function handle(Request $request, Closure $next, string $webhookType): Response
    {
        $headers = $request->headers->all();
        $authenticated = $this->hasValidBearerToken($request);

        if ($request->headers->has('Authorization')) {
            $headers['authorization'] = ['[REDACTED]'];
        }

        Log::info('Brevo webhook received.', [
            'webhook_type' => $webhookType,
            'method' => $request->method(),
            'url' => $request->fullUrl(),
            'ip' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'headers' => $headers,
            'query' => $request->query(),
            'payload' => $request->getContent(),
            'authenticated' => $authenticated,
        ]);

        if (! $authenticated) {
            return response()->json(['message' => 'Unauthenticated.'], 401)
                ->withHeaders(['WWW-Authenticate' => 'Bearer']);
        }

        return $next($request);
    }

    private function hasValidBearerToken(Request $request): bool
    {
        $configuredToken = config('services.brevo.webhook_token');
        $providedToken = $request->bearerToken();

        return is_string($configuredToken)
            && $configuredToken !== ''
            && is_string($providedToken)
            && hash_equals($configuredToken, $providedToken);
    }
}
