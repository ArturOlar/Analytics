<?php
namespace Project\Models;

use \Core\Model;
use Project\Models\DatabaseConnection;

class Product extends Model
{
    // получить все товары
    public static function getAllProducts()
    {
        $conn = DatabaseConnection::getInstance();
        $query = $conn->query("SELECT * FROM products");
        return $query->fetchAll(\PDO::FETCH_CLASS);
    }
}