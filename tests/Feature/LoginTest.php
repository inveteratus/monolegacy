<?php

namespace Tests\Feature;

use Fig\Http\Message\StatusCodeInterface;
use PHPUnit\Framework\Attributes\CoversNothing;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class LoginTest extends TestCase
{
    #[CoversNothing]
    #[Test]
    public function canSeePage(): void
    {
        $app = $this->getAppInstance();
        $request = $this->createRequest('GET', '/login');
        $response = $app->handle($request);
        $body = (string) $response->getBody();

        // Expect to see a 200 response code
        $this->assertEquals(StatusCodeInterface::STATUS_OK, $response->getStatusCode());

        // Expect to see the "email" and "password" labels
        $this->assertStringContainsString('Email', $body);
        $this->assertStringContainsString('Password', $body);

        // Expect to see the login button
        $this->assertStringContainsString('Login', $body);
    }


    protected function assetSeeStringsInOrder(array $needles, string $haystack): void
    {
        
    }
}
