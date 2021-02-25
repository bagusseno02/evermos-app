<?php


namespace App\Utilities\Responses;

abstract class AbstractApiBaseResponseBuilder
{
    abstract function build();
    abstract function showResponse();
}