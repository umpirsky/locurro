<?php

namespace Locurro\Exception;

class GeolocationException extends \RuntimeException implements Exception
{
    public function __construct($message, \Exception $previous)
    {
        parent::__construct($message, $previous->getCode(), $previous);
    }
}
