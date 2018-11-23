<?php

namespace RASA\NLU\Model;

use Webmozart\Assert\Assert;

/**
 * @author Maximilian Berghoff <Maximilian.Berghoff@mayflower.de>
 */
class Entity
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $value;
    private $start;
    private $end;
    private $extractor;
    private $confidence;

    private function __construct(string $name, string $value, $start, $end, $extractor, $confidence)
    {
        $this->name = $name;
        $this->value = $value;
        $this->start = $start;
        $this->end = $end;
        $this->extractor = $extractor;
        $this->confidence = $confidence;
    }

    public static function fromValues($values): Entity
    {
        Assert::isArray($values, 'Values to create an entity must be an array');
        Assert::keyExists($values, 'entity', 'An entity should have a "entity"');
        Assert::keyExists($values, 'value', 'An entity should have a "value"');
        Assert::keyExists($values, 'start', 'An entity should have a "start"');
        Assert::keyExists($values, 'end', 'An entity should have a "end"');        $end = $values['end'];
        Assert::keyExists($values, 'extractor', 'An entity should have a "extractor"');
        Assert::keyExists($values, 'confidence', 'An entity should have a "confidence"');

        return new self(
            $values['entity'],
            $values['value'],
            $values['start'],
            $values['end'],
            $values['extractor'],
            $values['confidence']
        );
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
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return mixed
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * @return mixed
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * @return mixed
     */
    public function getExtractor()
    {
        return $this->extractor;
    }

    /**
     * @return mixed
     */
    public function getConfidence()
    {
        return $this->confidence;
    }
}
