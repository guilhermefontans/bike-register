<?php

namespace App\Domain\Validator;

use Respect\Validation\Validator;

/**
 * Class BikeValidator
 *
 * @package App\Domain\Validator
 */
class BikeValidator implements ValidatorInterface
{
    /**
     * @var Validator
     */
    protected $validator;

    public function __construct()
    {
        $this->validator = new Validator();
        $this->validator->addRule(Validator::key('description', Validator::allOf(
            Validator::notEmpty()->setTemplate('A descrição deve ser informada'),
            Validator::length(3, 24)->setTemplate('Tamanho de descrição inválida')
        ))->setTemplate('O campo "description" é obrigatório'));
    }

    public function validate(array $data)
    {
        $this->validator->assert($data);
    }
}