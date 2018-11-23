<?php

namespace App\Command;

use RASA\NLU\EndpointFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

/**
 * @author Maximilian Berghoff <Maximilian.Berghoff@mayflower.de>
 */
abstract class CommonCommand extends Command
{
    /**
     * @var EndpointFactory
     */
    protected $endpoints;
    /**
     * @var SymfonyStyle
     */
    protected $io;

    public function __construct(EndpointFactory $endpoints)
    {
        parent::__construct(null);
        $this->endpoints = $endpoints;
    }

    public function initialize(InputInterface $input, OutputInterface $output)
    {
        parent::initialize($input, $output);
        $this->io = new SymfonyStyle($input, $output);
    }
}
