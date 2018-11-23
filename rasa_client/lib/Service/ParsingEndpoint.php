<?php

namespace RASA\NLU\Service;

use RASA\NLU\Model\ParseResponse;

/**
 * @author Maximilian Berghoff <Maximilian.Berghoff@mayflower.de>
 */
interface ParsingEndpoint
{
    /**
     * Parse a string to get its intents.
     *
     * @param string $value
     *
     * @return ParseResponse|null
     */
    public function parseString(string $value);
}
