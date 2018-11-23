<?php

namespace App\Command;

use RASA\NLU\Model\Model;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Maximilian Berghoff <Maximilian.Berghoff@mayflower.de>
 */
class RemoveModelCommand extends CommonCommand
{
    public function configure()
    {
        $this
            ->setName('rasa:nlu:remove-model')
            ->setDescription('Remove a training model.')
            ->addArgument('model', InputArgument::REQUIRED, 'Model key to remove')
            ->addOption('project', null, InputOption::VALUE_REQUIRED, 'Project to remove the model from');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $response = $this
            ->endpoints->getRemoveModelEndpoint($input->getOption('project'))
            ->removeModelFromProject(Model::fromString($input->getArgument('model')));
        if ($response) {
            $output->writeln('<info>REMOVED</info>');
        } else {
            $output->writeln('<error>ERROR</error>');
        }
        $this->io->writeln('');
    }
}
