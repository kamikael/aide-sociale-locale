<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class WebhookSignatureTest extends TestCase
{
    use RefreshDatabase;

    protected string $secret = 'test_secret';

    protected function setUp(): void
    {
        parent::setUp();

        config([
            'services.fedapay.webhook_secret' => $this->secret,
        ]);
    }

    public function test_webhook_accepts_valid_signature()
    {
        $payload = json_encode([
            'entity' => [
                'id' => 123
            ]
        ]);

        $signature = hash_hmac(
            'sha256',
            $payload,
            $this->secret
        );

        $response = $this->call(
            'POST',
            route('fedapay.callback'),
            [],
            [],
            [],
            [
                'HTTP_X_FEDAPAY_SIGNATURE' => $signature,
                'CONTENT_TYPE' => 'application/json',
            ],
            $payload
        );

        // Si middleware passe → ce ne sera PAS 403
        $this->assertNotEquals(403, $response->status());
    }

    public function test_webhook_rejects_invalid_signature()
    {
        $payload = json_encode([
            'entity' => [
                'id' => 123
            ]
        ]);

        $response = $this->call(
            'POST',
            route('fedapay.callback'),
            [],
            [],
            [],
            [
                'HTTP_X_FEDAPAY_SIGNATURE' => 'invalid_signature',
                'CONTENT_TYPE' => 'application/json',
            ],
            $payload
        );

        $response->assertStatus(403);
    }

    public function test_webhook_rejects_missing_signature()
    {
        $payload = json_encode([
            'entity' => [
                'id' => 123
            ]
        ]);

        $response = $this->call(
            'POST',
            route('fedapay.callback'),
            [],
            [],
            [],
            [
                'CONTENT_TYPE' => 'application/json',
            ],
            $payload
        );

        $response->assertStatus(403);
    }
}