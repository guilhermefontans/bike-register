<?php
declare(strict_types=1);

namespace Tests\Domain\Bike;

use App\Domain\Bike\Bike;
use Tests\TestCase;

/**
 * Class BikeTest
 *
 * @package Tests\Domain\Bike
 */
class BikeTest extends TestCase
{
    public function userProvider()
    {
        return [
            [1, 'bike de trilha', 'Caloi', 1000, new \DateTime(), 'João', 'Ciclista'],
            [2, 'bike de cidade', 'Caloi', 1100, new \DateTime(), 'Maria', 'Loja do centro'],
        ];
    }

    /**
     * @dataProvider userProvider
     * @param $id
     * @param $description
     * @param $model
     * @param $price
     * @param $purchaseDate
     * @param $buyerName
     * @param $storeName
     */
    public function testGetters($id, $description, $model, $price, $purchaseDate, $buyerName, $storeName)
    {
        $bike = new Bike($id, $description, $model, $price, $purchaseDate, $buyerName, $storeName);
        $this->assertEquals($id, $bike->getId());
    }

    /**
     * @dataProvider userProvider
     * @param $id
     * @param $description
     * @param $model
     * @param $price
     * @param $purchaseDate
     * @param $buyerName
     * @param $storeName
     */
    public function testJsonSerialize($id, $description, $model, $price, $purchaseDate, $buyerName, $storeName)
    {
        $bike = new Bike($id, $description, $model, $price, $purchaseDate, $buyerName, $storeName);

        $expectedPayload = json_encode([
            'id'             => $id,
            'descricao'      => $description,
            'modelo'         => $model,
            'preco'          => $price,
            'data-compra'    => $purchaseDate->format('Y-m-d'),
            'nome-comprador' => $buyerName,
            'nome-loja'      => $storeName,
        ]);

        $this->assertEquals($expectedPayload, json_encode($bike));
    }
}
