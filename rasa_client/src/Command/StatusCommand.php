<?php

namespace App\Command;

use RASA\NLU\Model\Model;
use RASA\NLU\Model\Status;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * @author Maximilian Berghoff <Maximilian.Berghoff@mayflower.de>
 */
class StatusCommand extends CommonCommand
{
    public function configure()
    {
        $this->setName('rasa:nlu:status')
            ->setDescription('return the available projects and models');
    }


    public function execute(InputInterface $input, OutputInterface $output)
    {
        $endpoint = $this->endpoints->getStatusEndpoint();
        $status = $endpoint->showProjectsAndTheirModels();
        if (!$status instanceof Status) {
            $this->io->error('We have a problem');
        }

        $output->writeln('Got following projects\ ');
        foreach ($status->getAvailableProjects() as $project) {
            $this->io->title('Project: '.$project->getName());
            $this->io->writeln('currently training:'.$project->getCurrentTrainingProcesses());
            $this->io->table(['Available Model'], array_map(function (Model $model) {return [$model->getValue()]; }, $project->getAvailableModels()));
            $this->io->table(['Loaded Model'], array_map(function (Model $model) {return [$model->getValue()]; }, $project->getLoadedModels()));
        }
        $this->io->writeln('');
    }
}
