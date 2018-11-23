<?php

namespace RASA\NLU\Model;

use Webmozart\Assert\Assert;

/**
 * @author Maximilian Berghoff <Maximilian.Berghoff@mayflower.de>
 */
class Status
{
    /**
     * @var int
     */
    private $maxTrainingProcesses;
    /**
     * @var int
     */
    private $currentTrainingProcesses;
    /**
     * @var []
     */
    private $availableProjects;

    public function __construct($maxTrainingProcesses, $currentTrainingProcesses, $availableProjects)
    {
        $this->maxTrainingProcesses = $maxTrainingProcesses;
        $this->currentTrainingProcesses = $currentTrainingProcesses;
        $this->availableProjects = $availableProjects;
    }

    public static function fromJsonString($json): Status
    {
        Assert::string($json);
        $jsonArray = json_decode($json, true);
        $maxTraningProcesses = $jsonArray['max_training_processes'] ?: 0;
        Assert::integer($maxTraningProcesses);
        $currentTrainingProcesses = $jsonArray['current_training_processes'] ?: 0;
        Assert::integer($currentTrainingProcesses);
        $availableProjects = [];

        Assert::isArray($jsonArray['available_projects'], '"available_projects" should be of type array in status');
        if (array_key_exists('available_projects', $jsonArray)) {
            Assert::isArray($jsonArray['available_projects']);
            foreach ($jsonArray['available_projects'] as $name => $projectValues) {
                $availableProjects[] = Project::fromJsonArrayAndName($projectValues, $name);
            }
        }

        return new self($maxTraningProcesses, $currentTrainingProcesses, $availableProjects);
    }

    /**
     * @return int
     */
    public function getMaxTrainingProcesses(): int
    {
        return $this->maxTrainingProcesses;
    }

    /**
     * @return int
     */
    public function getCurrentTrainingProcesses(): int
    {
        return $this->currentTrainingProcesses;
    }

    /**
     * @return Project[]
     */
    public function getAvailableProjects()
    {
        return $this->availableProjects;
    }
}
