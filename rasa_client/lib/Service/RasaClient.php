<?php

namespace RASA\NLU\Service;

use GuzzleHttp\Client;

/**
 * @author Maximilian Berghoff <Maximilian.Berghoff@mayflower.de>
 */
abstract class RasaClient extends Client
{
    /**
     * @var string
     */
    protected $endpoint;

    public function __construct(string $endpoint, array $configuration = [])
    {
        $this->endpoint = $endpoint;
        parent::__construct($configuration);
    }
}
