<?php


namespace Project\Models\Faker;


use Project\Models\DatabaseConnection;
use Project\Models\Report\ReportSalesProduct;
use Project\Models\Shop;

class FakerOrder extends FakerAbstractOrder
{
    // вставить 100 фейковых заказов в БД
    public function insertFakerData()
    {
        for ($i = 0; $i < 100; $i++) {

            $id_shop = 1 + array_rand(Shop::getAllShop());
            $date_sale = $this->getRandomDate();

            $conn = DatabaseConnection::getInstance();
            $query = "INSERT INTO `orders`(`id_shop`, `date_sale`) VALUES (?, ?)";
            $prepare = $conn->prepare($query);
            $prepare->execute([$id_shop, $date_sale]);
            $idOrder = $conn->lastInsertId();

            $fakerOrderProduct = new FakerOrderProduct();
            $fakerOrderProduct->insertFakerData($idOrder);
        }
        return;
    }

    // згенерировать случайную дату (используется для указания даты заказа в генерации фейковых заказов)
    private function getRandomDate()
    {
        $int = mt_rand(1601510400, 1609459199);
        return date("Y-m-d", $int);
    }
}