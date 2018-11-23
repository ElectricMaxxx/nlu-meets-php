<?php

namespace RASA\NLU\Model;

use Webmozart\Assert\Assert;

/**
 * @author Maximilian Berghoff <Maximilian.Berghoff@mayflower.de>
 */
class Project
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $status;
    /**
     * @var int
     */
    private $currentTrainingProcesses;
    /**
     * @var Model[]
     */
    private $availableModels;
    /**
     * @var Model[]
     */
    private $loadedModels;

    private function __construct($name, $status, $currentTrainingProcesses, $availableModels = [], $loadedModels = [])
    {
        $this->name = $name;
        $this->status = $status;
        $this->currentTrainingProcesses = $currentTrainingProcesses;
        $this->availableModels = $availableModels;
        $this->loadedModels = $loadedModels;
    }

    public static function fromJsonArrayAndName($values, $name): Project
    {
        Assert::string($name);
        Assert::isArray($values);

        $status = $values['status'] ?: 'none';
        $currentTrainingProcesses = $values['current_training_processes'] ?: 0;
        $availableModels = [];
        $loadedModels = [];

        // assert and convert available models
        Assert::keyExists($values, 'available_models', 'A Project would expect a \'available_models\' key.');
        Assert::isArray($values['available_models'], '"available_models" should be of type array in a project.');
        foreach ($values['available_models'] as $modelString) {
            $availableModels[] = Model::fromString($modelString);
        }

        // assert and convert loaded models
        Assert::keyExists($values, 'loaded_models', 'A Project would expect a \'loaded_models\' key.');
        Assert::isArray($values['loaded_models'], '"loaded_models" should be of type array in a project.');
        foreach ($values['loaded_models'] as $modelString) {
            $loadedModels[] = Model::fromString($modelString);
        }
        return new self($name, $status, $currentTrainingProcesses, $availableModels, $loadedModels);
    }

    public function __toString(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @return int
     */
    public function getCurrentTrainingProcesses(): int
    {
        return $this->currentTrainingProcesses;
    }

    /**
     * @return Model[]
     */
    public function getAvailableModels(): array
    {
        return $this->availableModels;
    }

    /**
     * @return Model[]
     */
    public function getLoadedModels(): array
    {
        return $this->loadedModels;
    }
}
