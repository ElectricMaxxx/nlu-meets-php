<?php

namespace RASA\NLU\Model;

use Webmozart\Assert\Assert;

/**
 * @author Maximilian Berghoff <Maximilian.Berghoff@mayflower.de>
 */
class TrainDataResponse
{
    /**
     * @var string
     */
    private $info;
    /**
     * @var Model
     */
    private $model;

    private function __construct(string $info, Model $model)
    {
        $this->info = $info;
        $this->model = $model;
    }

    public static function fromJsonString($json): TrainDataResponse
    {
        Assert::string($json, 'Create Project Response must be of type array');
        $jsonArray = json_decode($json, true);
        Assert::keyExists($jsonArray, 'info');
        $info = $jsonArray['info'];
        Assert::keyExists($jsonArray, 'model');
        $model = Model::fromString($jsonArray['model']);

        return new self($info, $model);
    }

    /**
     * @return string
     */
    public function getInfo(): string
    {
        return $this->info;
    }

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }
}
