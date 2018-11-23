<?php

namespace RASA\NLU;

use RASA\NLU\Service\GeneralEndpoint;
use RASA\NLU\Service\ParsingEndpoint;
use RASA\NLU\Service\ProjectEndpoint;
use RASA\NLU\Service\StatusEndpoint;
use RASA\NLU\Service\TrainModelsInProjectEndpoint;

/**
 * Factory to build our endpoints
 *
 * @author Maximilian Berghoff <Maximilian.Berghoff@mayflower.de>
 */
class EndpointFactory
{
    /**
     * @var string
     */
    private $endpoint;
    /**
     * @var array
     */
    private $configuration;

    public function __construct(string $endpoint, array $configuration = [])
    {
        $this->endpoint = $endpoint;
        $this->configuration = $configuration;
    }

    public function getStatusEndpoint(): StatusEndpoint
    {
        return new GeneralEndpoint($this->endpoint, $this->configuration);
    }

    public function getTrainModelsInProjectEndpoint($projectName): TrainModelsInProjectEndpoint
    {
        return new ProjectEndpoint($this->endpoint, $projectName, $this->configuration);
    }

    public function getParsingEndpoint($projectName): ParsingEndpoint
    {
        return new ProjectEndpoint($this->endpoint, $projectName, $this->configuration);
    }

    public function getRemoveModelEndpoint($projectName)
    {
        return new ProjectEndpoint($this->endpoint, $projectName, $this->configuration);
    }
}
