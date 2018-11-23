<?php

namespace RASA\NLU\Service;

use RASA\NLU\Model\Status;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Maximilian Berghoff <Maximilian.Berghoff@mayflower.de>
 */
class GeneralEndpoint extends RasaClient implements StatusEndpoint
{
    public function __construct(string $endpoint, array $configuration = [])
    {
        parent::__construct($endpoint, $configuration);
    }

    /**
     * @return Status|null
     */
    public function showProjectsAndTheirModels(): ?Status
    {
        $response = $this->get(sprintf('%s/status', $this->endpoint));
        if (Response::HTTP_OK !== $response->getStatusCode()) {
            return null;
        }

        return Status::fromJsonString($response->getBody()->getContents());
    }
}
