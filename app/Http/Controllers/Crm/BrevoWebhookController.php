<?php

namespace App\Http\Controllers\Crm;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class BrevoWebhookController extends Controller
{
    public function transactional(): JsonResponse
    {
        return $this->acknowledge();
    }

    public function inbound(): JsonResponse
    {
        return $this->acknowledge();
    }

    public function marketing(): JsonResponse
    {
        return $this->acknowledge();
    }

    private function acknowledge(): JsonResponse
    {
        return response()->json(['received' => true]);
    }
}
