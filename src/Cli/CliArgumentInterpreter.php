<?php
namespace Cli;


class CliArgumentInterpreter
{
    public static function getConfigArguments(array $rawArguments): array
    {
        $result = [];

        foreach($rawArguments as $rawArgument) {
            $argumentBuf = explode('=', $rawArgument);

            if (is_array($argumentBuf) && count($argumentBuf) == 2) {
                $result[$argumentBuf[0]] = $argumentBuf[1];
            }
        }

        return $result;
    }
}