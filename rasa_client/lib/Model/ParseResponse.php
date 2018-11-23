<?php

namespace RASA\NLU\Model;

use Webmozart\Assert\Assert;

/**
 * @author Maximilian Berghoff <Maximilian.Berghoff@mayflower.de>
 */
class ParseResponse
{
    /**
     * @var Intent
     */
    private $intent;
    /**
     * @var array|Entity[]
     */
    private $entities;
    /**
     * @var array|Intent[]
     */
    private $intentRanking;
    /**
     * @var string
     */
    private $text;
    /**
     * @var string
     */
    private $projectKey;
    /**
     * @var Model
     */
    private $model;

    /**
     * ParseResponse constructor.
     *
     * @param Intent $intent
     * @param Entity[] $entities
     * @param Intent[] $intentRanking
     */
    private function __construct($intent = null, array $entities, array $intentRanking, string $text, string $projectKey, Model $model)
    {
        $this->intent = $intent;
        $this->entities = $entities;
        $this->intentRanking = $intentRanking;
        $this->text = $text;
        $this->projectKey = $projectKey;
        $this->model = $model;
    }

    public static function fromJsonString($value): ParseResponse
    {
        Assert::string($value, 'Parsed Response Value should be a string');
        $jsonArray = json_decode($value, true);
        $intent = array_key_exists('intent', $jsonArray) ? Intent::fromArray($jsonArray['intent']) : null;

        $entities = [];
        if (array_key_exists('entities', $jsonArray)) {
            Assert::isArray($jsonArray['entities'], '"entities" on parse response must be an array of arrays');
            foreach ($jsonArray['entities'] as $position => $jsonEntities) {
                Assert::isArray($jsonEntities, '"entities" include an array again');
                $entities[] = Entity::fromValues($jsonEntities);
            }
        }

        $intentRanking = [];
        if (array_key_exists('intent_ranking', $jsonArray)) {
            Assert::isArray($jsonArray['intent_ranking'], '"intent_ranking" on parse response must be an array');
            foreach ($jsonArray['intent_ranking'] as $intentValues) {
                $intentRanking[] = Intent::fromArray($intentValues);
            }
        }

        Assert::string($jsonArray['text']);
        Assert::string($jsonArray['project']);
        Assert::string($jsonArray['model']);

        return new self(
            $intent,
            $entities,
            $intentRanking,
            $jsonArray['text'],
            $jsonArray['project'],
            Model::fromString($jsonArray['model'])
        );
    }

    /**
     * @return Intent
     */
    public function getIntent(): Intent
    {
        return $this->intent;
    }

    /**
     * @return array|Entity[]
     */
    public function getEntities()
    {
        return $this->entities;
    }

    /**
     * @return array|Intent[]
     */
    public function getIntentRanking()
    {
        return $this->intentRanking;
    }

    /**
     * @return string
     */
    public function getText(): string
    {
        return $this->text;
    }

    /**
     * @return string
     */
    public function getProjectKey(): string
    {
        return $this->projectKey;
    }

    /**
     * @return Model
     */
    public function getModel(): Model
    {
        return $this->model;
    }
}
