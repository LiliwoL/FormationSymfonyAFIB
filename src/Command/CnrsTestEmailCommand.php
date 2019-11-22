<?php

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class CnrsTestEmailCommand extends Command
{
    protected static $defaultName = 'cnrs:test-email';

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('arg1', InputArgument::OPTIONAL, 'Argument description')
            ->addOption('option1', null, InputOption::VALUE_NONE, 'Option description')

            // the full command description shown when running the command with
            // the "--help" option
            ->setHelp('Commande spécifique au CNRS...')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $arg1 = $input->getArgument('arg1');

        if ($arg1) {
            $io->note(sprintf('You passed an argument: %s', $arg1));
        }

        if ($input->getOption('option1')) {
            // ...
        }

        // Injection de dépendances manuelle
        $kernel = $this->getApplication()->getKernel();
        $mailer = $kernel->getContainer()->get('mailer');

        $message = (new \Swift_Message('Mail de test envoyé via une commande Symfony'))
            ->setFrom('send@example.com')
            ->setTo('recipient@example.com')
            ->setBody(
                "Mail envoyé via une Commande Symfony"
            );

        $mailer->send($message);

        $io->success('You have a new command! Now make it your own! Pass --help to see your options.');

        return 0;
    }
}
