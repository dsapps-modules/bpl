<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Log;
use Mockery;
use Tests\TestCase;

class BrevoWebhookTest extends TestCase
{
    public function test_it_logs_the_received_brevo_webhook_and_returns_success(): void
    {
        Log::spy();

        $payload = '{"event":"delivered","message-id":"message-123"}';

        $response = $this->call(
            'POST',
            '/api/crm/v1/webhooks/brevo/account-123?source=brevo',
            [],
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
            ],
            $payload,
        );

        $response->assertOk()
            ->assertJson(['received' => true]);

        Log::shouldHaveReceived('info')
            ->once()
            ->with(
                'Brevo webhook received.',
                Mockery::on(function (array $context) use ($payload): bool {
                    return $context['channel_account'] === 'account-123'
                        && $context['method'] === 'POST'
                        && $context['query'] === ['source' => 'brevo']
                        && $context['payload'] === $payload;
                }),
            );
    }
}
