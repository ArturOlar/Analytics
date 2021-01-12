<?php


namespace Project\Models\Faker;


use Project\Models\DatabaseConnection;
use Project\Models\Product;

class FakerOrderProduct extends FakerAbstractOrder
{
    // сохранить фейковые заказанные товары в таблицу orders_product
    public function insertFakerData($idOrder = null)
    {
        $allProducts = Product::getAllProducts();
        $countSKUByOrder = rand(1, 5);
        $fail = 0;
        $idProductByOrder = [];

        for ($i = 0; $i < $countSKUByOrder; $i++) {
            $randProduct = array_rand($allProducts);

            if (!in_array($allProducts[$randProduct], $idProductByOrder)) {
                $idProductByOrder[] = $allProducts[$randProduct];
            } else {
                $fail++;
            }
        }

        for ($i = 0; $i < ($countSKUByOrder - $fail); $i++) {
            $id_order = $idOrder;
            $id_product = $idProductByOrder[$i]->id;
            $count = rand(1, 3);
            $price = $idProductByOrder[$i]->price;
            $discount = rand(0, 100);
            $finalPrice = $price - $discount;
            $profit = $finalPrice / rand(5, 20);
            $cost_price = $finalPrice - $profit;

            $conn = DatabaseConnection::getInstance();
            $query = "INSERT INTO `orders_product`(`id_order`, `id_product`, `count`, `price`, `discount`, `final_price`, `profit`, `cost_price`) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
            $prepare = $conn->prepare($query);
            $prepare->execute([$id_order, $id_product, $count, $price, $discount, $finalPrice, $profit, $cost_price]);
        }
        return;
    }
}