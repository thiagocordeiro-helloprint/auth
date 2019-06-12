<?php declare(strict_types=1);

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;
use Symfony\Component\DependencyInjection\ContainerInterface;

class SymfonyTestCase extends KernelTestCase
{
    private ContainerInterface $container;

    /**
     * @return mixed
     */
    public function getService(string $id)
    {
        return $this->getContainer()->get($id);
    }

    public function setService(string $id, object $service): void
    {
        $this->getContainer()->set($id, $service);
    }

    private function getContainer(): ContainerInterface
    {
        if (!$this->container) {
            $this->container = parent::bootKernel()->getContainer();
        }

        return $this->container;
    }
}
