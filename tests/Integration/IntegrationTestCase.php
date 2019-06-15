<?php declare(strict_types=1);

namespace App\Tests\Integration;

use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class IntegrationTestCase extends WebTestCase
{
    protected KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    protected function setService(string $id, object $service): void
    {
        $this->client->getContainer()->set($id, $service);
    }

    protected function post(string $uri, array $data): Response
    {
        $this->client->request('POST', $uri, [], [], [], json_encode($data));

        return $this->client->getResponse();
    }
}
