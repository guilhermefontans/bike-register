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
        $this->validator->addRule(
            Validator::key(
                'descricao', Validator::allOf(
                    Validator::notEmpty()->setTemplate('The description must not be empty'),
                    Validator::length(3, 255)->setTemplate('Invalid length')
                )
            )->setTemplate("The key 'descricao' is required")
        );

        $this->validator->addRule(
            Validator::key(
                'modelo', Validator::allOf(
                    Validator::notEmpty()->setTemplate('The model must not be empty'),
                    Validator::length(1, 100)->setTemplate('Invalid length')
                )
            )->setTemplate("The key 'modelo' is required")
        );

        $this->validator->addRule(
            Validator::key(
                'nome-comprador', Validator::allOf(
                    Validator::notEmpty()->setTemplate('The nome-comprador must not be empty'),
                    Validator::length(2, 50)->setTemplate('Invalid length')
                )
            )->setTemplate("The key 'nome-comprador' is required")
        );

        $this->validator->addRule(
            Validator::key(
                'nome-loja', Validator::allOf(
                    Validator::notEmpty()->setTemplate('The nome-loja must not be empty'),
                    Validator::length(3, 255)->setTemplate('Invalid length')
                )
            )->setTemplate("The key 'nome-loja' is required")
        );

        $this->validator->addRule(
            Validator::key(
                'data-compra', Validator::allOf(
                Validator::date('Y-m-d')->setTemplate('Invalid date')
            )
            )->setTemplate("The key 'data-compra' is required")
        );

        $this->validator->addRule(
            Validator::key(
                'preco', Validator::allOf(
                    Validator::floatVal()->setTemplate('Price must be a float')
                )
            )->setTemplate("The key 'preco' is required")
        );
    }

    public function validate(array $data)
    {
        $this->validator->assert($data);
    }
}