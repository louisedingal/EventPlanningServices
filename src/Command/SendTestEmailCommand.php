<?php

namespace App\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;

#[AsCommand(
    name: 'app:send-test-email',
    aliases: ['app:test-email'],
    description: 'Send a test email to verify mailer delivery (SMTP locally, Brevo API on Railway).'
)]
class SendTestEmailCommand extends Command
{
    public function __construct(
        private MailerInterface $mailer,
        #[Autowire('%env(MAILER_FROM_ADDRESS)%')] private string $fromAddress,
        #[Autowire('%env(MAILER_FROM_NAME)%')] private string $fromName,
    ) {
        parent::__construct();

        $this->fromAddress = trim($this->fromAddress, " \t\n\r\0\x0B\"'");
        $this->fromName = trim($this->fromName, " \t\n\r\0\x0B\"'");
    }

    protected function configure(): void
    {
        $this
            ->addArgument('to', InputArgument::REQUIRED, 'Recipient email address (e.g., your@gmail.com)');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $to = (string) $input->getArgument('to');
        $to = trim($to);

        $email = (new Email())
            ->from(new Address($this->fromAddress, $this->fromName))
            ->to(new Address($to))
            ->subject('Lux Events - SMTP test')
            ->text('This is a Symfony mailer test email. If you received this, SMTP is working.');

        try {
            $this->mailer->send($email);
        } catch (\Throwable $e) {
            $output->writeln('<error>Send failed:</error> ' . $e->getMessage());
            return Command::FAILURE;
        }

        $output->writeln('<info>Test email sent successfully.</info>');
        return Command::SUCCESS;
    }
}

