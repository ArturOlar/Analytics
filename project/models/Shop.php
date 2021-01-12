<?php
namespace Project\Models;

use \Core\Model;
use Project\Models\DatabaseConnection;

class Shop extends Model
{
    // получить все магазины
    public static function getAllShop()
    {
        $conn = DatabaseConnection::getInstance();
        $query = $conn->query("SELECT * FROM shops");
        return $query->fetchAll(\PDO::FETCH_CLASS);
    }

    // форматировать массив магазинов для выборки из БД и передачи выбраных магазинов в представление
    public static function getCorrectFormatShops ($shopsPOST = null)
    {
        if ($shopsPOST != null) {
            $shops = $shopsPOST;
            $shop = implode(', ', $shops);
        } else {
            $shopsObj = Shop::getAllShop();
            foreach ($shopsObj as $key => $value) {
                $shops[] = $value->id;
            }
            $shop = implode(', ', $shops);
        }
        $res['shopsFromView'] = $shops;
        $res['shopsFromDB'] = $shop;
        return $res;
    }
}