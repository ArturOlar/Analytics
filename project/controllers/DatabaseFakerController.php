<?php
namespace Project\Controllers;

use \Core\Controller;
use Project\Models\Faker\FakerOrder;
use Project\Models\Faker\FakerProduct;

class DatabaseFakerController extends Controller
{
    // вставить 100 фейковых товаров в БД
    public function insertFakerProduct()
    {
        $product = new FakerProduct();
        $product->insertFakerData();
        header('location: /');
    }
    
    // вставить 100 фейковых заказов в БД
    public function insertFakerOrders()
    {
        $order = new FakerOrder();
        $order->insertFakerData();
        header('location: /');
    }
}
