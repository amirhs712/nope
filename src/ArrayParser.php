<?php


namespace Amirhs712\RuleBuilder;


class ArrayParser implements Parser
{
    public function parse($name, $arguments = null)
    {
        if ($name) {
            return $arguments ? "$name:$arguments" : $name;
        }

        return $arguments;
    }

}
