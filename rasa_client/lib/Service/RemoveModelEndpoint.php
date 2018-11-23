<?php

namespace RASA\NLU\Service;

use RASA\NLU\Model\Model;

/**
 * @author Maximilian Berghoff <Maximilian.Berghoff@mayflower.de>
 */
interface RemoveModelEndpoint
{
    /**
     * Endpoint to remove a model by its key.
     *
     * @param Model $model
     *
     * @return bool
     */
    public function removeModelFromProject(Model $model): bool;
}
