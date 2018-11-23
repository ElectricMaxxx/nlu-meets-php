<?php

namespace RASA\NLU\Service;

use RASA\NLU\Model\ParseResponse;
use RASA\NLU\Model\TrainDataResponse;
use RASA\NLU\Model\Model;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Maximilian Berghoff <Maximilian.Berghoff@mayflower.de>
 */
class ProjectEndpoint extends RasaClient implements TrainModelsInProjectEndpoint, ParsingEndpoint, RemoveModelEndpoint
{
    /**
     * @var string
     */
    private $projectName;

    public function __construct(string $endpoint, string $projectName, array $configuration = [])
    {
        parent::__construct($endpoint, $configuration);
        $this->projectName = $projectName;
    }

    /**
     * @param Model $model
     * @param $projectName
     *
     * @return bool
     */
    public function removeModelFromProject(Model $model): bool
    {
        $response = $this->delete(sprintf('%s/models?project=%s&model=%s', $this->endpoint, $this->projectName, $model));

        return $response->getStatusCode() === Response::HTTP_OK;
    }

    /**
     * @param $dataFile
     *
     * @return TrainDataResponse|null
     */
    public function trainByDataFile($dataFile): ?TrainDataResponse
    {
        $fileContent = file_get_contents($dataFile);
        $promise = $this->postAsync(
            sprintf('%s/train?project=%s', $this->endpoint, $this->projectName),
            ['body' => $fileContent, 'headers' => ['Content-Type' => 'application/x-yml']]
        )->then(function (\GuzzleHttp\Psr7\Response $response) {
            if ($response->getStatusCode() !== Response::HTTP_OK) {
                return $response->getBody()->getContents();
            }

            try {
                return TrainDataResponse::fromJsonString($response->getBody()->getContents());
            } catch (\InvalidArgumentException $exception) {
                print("\n ERROR: ".$exception->getMessage());
                return null;
            }
        })->otherwise(function ($response) {
            if ($response instanceof  \Error) {
                return $response->getMessage();
            } elseif ($response instanceof \Exception) {
                return $response->getMessage();
            }

            return $response;
        });

        return $promise->wait(true);
    }

    /**
     * @param string $value
     *
     * @return ParseResponse|null
     */
    public function parseString(string $value)
    {
        $promise = $this->postAsync(
            sprintf('%s/parse', $this->endpoint),
            ['json' => ['q' => $value, 'project' => $this->projectName], 'headers' => ['Content-Type' => 'application/json']]
        )->then(function (\GuzzleHttp\Psr7\Response $response) {
            if (Response::HTTP_OK !== $response->getStatusCode()) {
                return $response->getBody()->getContents();
            }

            try {
                return ParseResponse::fromJsonString($response->getBody()->getContents());
            } catch (\InvalidArgumentException $exception) {
                print("\n ERROR: ".$exception->getMessage());
                return null;
            }
        })->otherwise(function (\GuzzleHttp\Psr7\Response $response) {
            if ($response instanceof  \Error) {
                return $response->getMessage();
            } elseif ($response instanceof \Exception) {
                return $response->getMessage();
            }

            return $response;
        });

        return $promise->wait();
    }
}
