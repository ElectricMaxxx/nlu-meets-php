<?php

namespace RASA\NLU\Model;

use Webmozart\Assert\Assert;

/**
 * @author Maximilian Berghoff <Maximilian.Berghoff@mayflower.de>
 */
class Intent
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $confidence;

    private function __construct(string  $name, string  $confidence)
    {
        $this->name = $name;
        $this->confidence = $confidence;
    }

    public static function fromArray($values): Intent
    {
        Assert::keyExists($values, 'name', '"intent" must exist on intent values');
        $name = $values['name'];
        Assert::keyExists($values, 'confidence', '"confidence" must exist on intent values');
        $confidence = $values['confidence'];

        return new self($name, $confidence);
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
    public function getConfidence(): string
    {
        return $this->confidence;
    }
}
