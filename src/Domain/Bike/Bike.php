<?php

namespace App\Domain\Bike;

use App\Domain\Factory\EntityInterface;
use JsonSerializable;

/**
 * Class Bike
 *
 * @package App\Domain\Bike
 */
class Bike implements JsonSerializable, EntityInterface
{
    /**
     * @var int|null
     */
    private $id;
    /**
     * @var string
     */
    private $description;
    /**
     * @var string
     */
    private $model;
    /**
     * @var float
     */
    private $price;
    /**
     * @var \Datetime
     */
    private $purchaseDate;
    /**
     * @var string
     */
    private $buyerName;
    /**
     * @var string
     */
    private $storeName;

    /**
     * Bike constructor.
     * @param int|null $id
     * @param string $description
     * @param string $model
     * @param float $price
     * @param \DateTime $purchaseDate
     * @param string $buyerName
     * @param string $storeName
     */
    public function __construct(
        ?int $id,
        string $description,
        string $model,
        float $price,
        \DateTime $purchaseDate,
        string $buyerName,
        string $storeName
    ) {
        $this->id = $id;
        $this->description = $description;
        $this->model = $model;
        $this->price = $price;
        $this->purchaseDate = $purchaseDate;
        $this->buyerName = $buyerName;
        $this->storeName = $storeName;
    }

    public function jsonSerialize()
    {
        return [
            "id"             => $this->id,
            "descricao"      => $this->description,
            "modelo"         => $this->model,
            "preco"          => $this->price,
            "data-compra"    => $this->purchaseDate->format('Y-m-d'),
            "nome-comprador" => $this->buyerName,
            "nome-loja"      => $this->storeName
        ];
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }
}