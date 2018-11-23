<?php

namespace App\Command;

use RASA\NLU\Model\Entity;
use RASA\NLU\Model\Intent;
use RASA\NLU\Model\ParseResponse;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Webmozart\Assert\Assert;

/**
 * @author Maximilian Berghoff <Maximilian.Berghoff@mayflower.de>
 */
class ParseTextCommand extends CommonCommand
{
    public function configure()
    {
        $this
            ->setName('rasa:nlu:parse')
            ->setDescription('Parse a given text for its intents.')
            ->addArgument('text', InputArgument::REQUIRED, 'Text to parse')
            ->addOption('project', 'p',  InputOption::VALUE_REQUIRED, 'Project to use for the parsing request');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $text = $input->getArgument('text');
        $project = $input->getOption('project');
        try {
            Assert::notEmpty($text);
        } catch (\InvalidArgumentException $e) {
           $this->io->error('It makes no sense to parse an empty string.');
            return;
        }

        $response = $this->endpoints->getParsingEndpoint($project)->parseString($text);
        if (!$response instanceof ParseResponse) {
            $this->io->error('Got wrong response');
            return;
        }

        if (!$response->getIntent() instanceof  Intent) {
            $this->io->error('No Intent given.');
            return;
        }
        $this->io->title('Intent: '.$response->getIntent()->getName().' - Confidence: '.$response->getIntent()->getConfidence());
        
        $this->io->writeln('Entities found:');
        if (is_array($response->getEntities())) {
            $this->io->table(['Name', 'Value', 'start', 'end', 'extractor', 'confidence'], array_map(function (Entity $entity) {
                return [$entity->getName(), $entity->getValue(), $entity->getStart(), $entity->getEnd(), $entity->getExtractor(), $entity->getConfidence()];
            }, $response->getEntities()));
        }
        $this->io->writeln('');

        $this->io->writeln('Ranking:');
        if (is_array($response->getIntentRanking())) {
            $this->io->table(['Pos.', 'Name', 'Confidence'], array_map(function (Intent $intent) {
                return [$intent->getName(), $intent->getConfidence()];
            }, $response->getIntentRanking()));
        }
    }
}
