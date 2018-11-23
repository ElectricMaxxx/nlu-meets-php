<?php

namespace App\Command;

use RASA\NLU\Service\TrainModelsInProjectEndpoint;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Maximilian Berghoff <Maximilian.Berghoff@mayflower.de>
 */
class TrainModelCommand extends CommonCommand
{
    public function configure()
    {
        $this
            ->setName('rasa:nlu:train')
            ->setDescription(
                'Train a project by a well defined training data. For the training data you should have a look into: https://rasa.com/docs/nlu/dataformat/'
            )
            ->addArgument('filePath', InputArgument::REQUIRED, 'File path for the training data')
            ->addOption(
                'project',
                'p',
                InputOption::VALUE_REQUIRED,
                'The project to train. Run "rasa:nlu:status" to get available project or choose a new key'
            );
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $filePath = $input->getArgument('filePath');
        $project = $input->getOption('project');
        if (!file_exists($filePath)) {
            $output->writeln(sprintf('<error>File "%s" to train a project "%s" does not exist.</error>', $filePath, $project));

            return;
        }
        $endpoint = $this->endpoints->getTrainModelsInProjectEndpoint($project);
        $response = $endpoint->trainByDataFile($filePath);

        $this->io->title($response->getInfo());
        $this->io->writeln('Created Model: '.$response->getModel());
        $this->io->writeln('');
    }
}
