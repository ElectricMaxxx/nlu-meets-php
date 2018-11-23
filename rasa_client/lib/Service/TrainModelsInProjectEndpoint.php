<?php

namespace RASA\NLU\Service;

use RASA\NLU\Model\TrainDataResponse;

/**
 * @author Maximilian Berghoff <Maximilian.Berghoff@mayflower.de>
 */
interface TrainModelsInProjectEndpoint
{
    /**
     * Use this endpoint to train models of a given project.
     *
     * To do so you have pass a file path to get the training data defined like:
     *
     * https://rasa.com/docs/nlu/dataformat/
     *
     * @param $dataFile
     *
     * @return TrainDataResponse|null
     */
    public function trainByDataFile($dataFile): ?TrainDataResponse;
}
