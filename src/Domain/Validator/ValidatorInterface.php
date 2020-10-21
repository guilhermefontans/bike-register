<?php


namespace App\Domain\Validator;


interface ValidatorInterface
{
    public function validate(array $data);
}