<?php

namespace RASA\NLU\Service;

use RASA\NLU\Model\Status;

/**
 * @author Maximilian Berghoff <Maximilian.Berghoff@mayflower.de>
 */
interface StatusEndpoint
{
    /**
     * This endpoint will gerate a list of projects with their available models to parse text.
     *
     * @return Status|null
     */
    public function showProjectsAndTheirModels(): ?Status;
}
