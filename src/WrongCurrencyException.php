<?php

namespace unapi\helper\money;

class WrongCurrencyException extends \RuntimeException
{
    public $message = 'Wrong currency value';
}