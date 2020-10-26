<?php


namespace Amirhs712\RuleBuilder;


class StringParser implements Parser
{
    public function parse($name, $arguments = null)
    {
        return $this->parseRuleAsString($name, $arguments);
    }

    private function parseRuleAsString($name, $arguments = null)
    {
        $arguments = $this->parseToString($arguments);
        if ($name) {
            return $arguments ? "$name:$arguments" : $name;
        }

        return $arguments;
    }

    private function parseToString($value)
    {
        if ($value === null) {
            return null;
        }

        return (string)$value;
    }
}


