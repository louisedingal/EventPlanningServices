<?php

namespace App\Command;

use App\Entity\User;
use App\Service\EmailVerificationService;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:send-verification-email-test',
    description: 'Send the verification email template to a provided address (diagnostic).'
)]
class SendVerificationEmailTestCommand extends Command
{
    public function __construct(
        private EmailVerificationService $emailVerificationService,
    ) {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->addArgument('to', InputArgument::REQUIRED, 'Recipient email address (e.g., your@gmail.com)')
            ->addArgument('verificationUrl', InputArgument::OPTIONAL, 'Verification URL to embed in the email', 'http://localhost/verify-email/test-token');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $to = trim((string) $input->getArgument('to'));
        $verificationUrl = (string) $input->getArgument('verificationUrl');

        $user = new User();
        $user->setEmail($to);
        $user->setUsername('TestUser');

        try {
            $this->emailVerificationService->sendVerificationEmail($user, $verificationUrl);
        } catch (\Throwable $e) {
            $output->writeln('<error>Send failed:</error> ' . $e->getMessage());
            return Command::FAILURE;
        }

        $output->writeln('<info>Verification test email sent successfully.</info>');
        return Command::SUCCESS;
    }
}

