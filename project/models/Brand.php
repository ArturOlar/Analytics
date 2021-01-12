<?php
namespace Project\Models;

use \Core\Model;
use Project\Models\DatabaseConnection;

class Brand extends Model
{
    // получить все бренды
    public static function getAllBrands()
    {
        $conn = DatabaseConnection::getInstance();
        $query = $conn->query("SELECT * FROM brand");
        return $query->fetchAll(\PDO::FETCH_CLASS);
    }

    public static function getCorrectBrandsByFilter($brandsPOST)
    {
        if ($brandsPOST != null) {
            $brands = $brandsPOST;
            $brand = implode(', ', $brands);
        } else {
            $brandObj = Brand::getAllBrands();
            foreach ($brandObj as $key => $value) {
                $brands[] = $value->id;
            }
            $brand = implode(', ', $brands);
        }
        $res['brandsFromView'] = $brands;
        $res['brandsFromDB'] = $brand;
        return $res;
    }
}