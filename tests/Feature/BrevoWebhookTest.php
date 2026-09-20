<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Log;
use Mockery;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class BrevoWebhookTest extends TestCase
{
    #[DataProvider('webhookTypes')]
    public function test_it_logs_the_received_brevo_webhook_and_returns_success(string $webhookType): void
    {
        config()->set('services.brevo.webhook_token', 'test-token');
        Log::spy();

        $payload = '{"event":"delivered","message-id":"message-123"}';

        $response = $this->call(
            'POST',
            "/crm/v1/webhooks/brevo/{$webhookType}?source=brevo",
            [],
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
                'HTTP_AUTHORIZATION' => 'Bearer test-token',
            ],
            $payload,
        );

        $response->assertOk()
            ->assertJson(['received' => true]);

        Log::shouldHaveReceived('info')
            ->once()
            ->with(
                'Brevo webhook received.',
                Mockery::on(function (array $context) use ($payload, $webhookType): bool {
                    return $context['webhook_type'] === $webhookType
                        && $context['method'] === 'POST'
                        && $context['headers']['authorization'] === ['[REDACTED]']
                        && $context['query'] === ['source' => 'brevo']
                        && $context['payload'] === $payload;
                }),
            );
    }

    public static function webhookTypes(): array
    {
        return [
            'transactional' => ['transactional'],
            'inbound' => ['inbound'],
            'marketing' => ['marketing'],
        ];
    }

    public function test_it_rejects_a_webhook_without_a_bearer_token(): void
    {
        config()->set('services.brevo.webhook_token', 'test-token');

        $response = $this->postJson('/crm/v1/webhooks/brevo/transactional', [
            'event' => 'delivered',
        ]);

        $response->assertUnauthorized()
            ->assertJson(['message' => 'Unauthenticated.']);
    }

    public function test_it_rejects_a_webhook_with_an_invalid_bearer_token(): void
    {
        config()->set('services.brevo.webhook_token', 'test-token');

        $response = $this->withHeader('Authorization', 'Bearer invalid-token')
            ->postJson('/crm/v1/webhooks/brevo/inbound', [
                'event' => 'delivered',
            ]);

        $response->assertUnauthorized()
            ->assertJson(['message' => 'Unauthenticated.']);
    }
}
