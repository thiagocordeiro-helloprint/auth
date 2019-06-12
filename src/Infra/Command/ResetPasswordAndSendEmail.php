<?php declare(strict_types=1);

namespace App\Infra\Command;

use App\AuthService\User\ResetPasswordService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ResetPasswordAndSendEmail extends Command
{
    private ResetPasswordService $service;

    public function __construct(ResetPasswordService $service)
    {
        parent::__construct('password:reset');

        $this->service = $service;
    }

    protected function configure(): void
    {
        $this->setDescription('Reset password of inactive users and sent via email');
    }

    protected function execute(InputInterface $input, OutputInterface $output): void
    {
        $this->service->resetInactiveUsers();
    }
}
