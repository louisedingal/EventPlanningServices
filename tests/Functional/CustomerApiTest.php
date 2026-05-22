<?php

namespace App\Tests\Functional;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CustomerApiTest extends WebTestCase
{
    private ?string $token = null;

    protected function setUp(): void
    {
        parent::setUp();
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/login',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode([
                'username' => 'customer@gmail.com',
                'password' => 'customer123',
            ], \JSON_THROW_ON_ERROR)
        );

        self::assertResponseIsSuccessful();
        $payload = json_decode($client->getResponse()->getContent(), true, 512, \JSON_THROW_ON_ERROR);
        self::assertArrayHasKey('token', $payload);
        $this->token = $payload['token'];
    }

    private function authHeaders(): array
    {
        return [
            'HTTP_AUTHORIZATION' => 'Bearer ' . $this->token,
            'CONTENT_TYPE' => 'application/json',
        ];
    }

    public function testCustomerMe(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/customer/me', [], [], $this->authHeaders());
        self::assertResponseIsSuccessful();
        $body = json_decode($client->getResponse()->getContent(), true, 512, \JSON_THROW_ON_ERROR);
        self::assertTrue($body['success']);
        self::assertSame('customer@gmail.com', $body['data']['email']);
    }

    public function testCustomerCatalogVenues(): void
    {
        $client = static::createClient();
        $client->request('GET', '/api/customer/catalog/venues', [], [], $this->authHeaders());
        self::assertResponseIsSuccessful();
        $body = json_decode($client->getResponse()->getContent(), true, 512, \JSON_THROW_ON_ERROR);
        self::assertTrue($body['success']);
        self::assertArrayHasKey('items', $body['data']);
    }

    public function testCustomerEventRequestCrud(): void
    {
        $client = static::createClient();

        $client->request(
            'POST',
            '/api/customer/event-requests',
            [],
            [],
            $this->authHeaders(),
            json_encode([
                'eventType' => 'Birthday',
                'preferredDate' => '2026-12-01',
                'estimatedGuestCount' => 50,
                'preferredVenue' => 'Test Hall',
                'theme' => 'Modern',
                'budget' => '25000',
            ], \JSON_THROW_ON_ERROR)
        );
        self::assertResponseStatusCodeSame(201);
        $created = json_decode($client->getResponse()->getContent(), true, 512, \JSON_THROW_ON_ERROR);
        self::assertTrue($created['success']);
        $id = $created['data']['id'];
        self::assertSame('pending', $created['data']['status']);

        $client->request('GET', '/api/customer/event-requests/' . $id, [], [], $this->authHeaders());
        self::assertResponseIsSuccessful();

        $client->request(
            'PUT',
            '/api/customer/event-requests/' . $id,
            [],
            [],
            $this->authHeaders(),
            json_encode(['theme' => 'Updated Theme'], \JSON_THROW_ON_ERROR)
        );
        self::assertResponseIsSuccessful();
        $updated = json_decode($client->getResponse()->getContent(), true, 512, \JSON_THROW_ON_ERROR);
        self::assertSame('Updated Theme', $updated['data']['theme']);

        $client->request('DELETE', '/api/customer/event-requests/' . $id, [], [], $this->authHeaders());
        self::assertResponseIsSuccessful();
    }
}
