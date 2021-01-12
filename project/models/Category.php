<?php
namespace Project\Models;

use \Core\Model;
use Project\Models\DatabaseConnection;

class Category extends Model
{
    // получить все категории
    public static function getAllCategories()
    {
        $conn = DatabaseConnection::getInstance();
        $query = $conn->query("SELECT * FROM categories");
        return $query->fetchAll(\PDO::FETCH_CLASS);
    }

    public static function getCorrectCategoriesByFilter($categoriesPOST = null)
    {
        if ($categoriesPOST != null) {
            $categories = $categoriesPOST;
            $category = implode(', ', $categories);
        } else {
            $categoryObj = Category::getAllCategories();
            foreach ($categoryObj as $key => $value) {
                $categories[] = $value->id;
            }
            $category = implode(', ', $categories);
        }
        $res['categoriesFromView'] = $categories;
        $res['categoriesFromDB'] = $category;
        return $res;
    }
}