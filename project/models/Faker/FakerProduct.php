<?php


namespace Project\Models\Faker;


use Project\Models\Brand;
use Project\Models\Category;
use Project\Models\CountryManufacturer;
use Project\Models\DatabaseConnection;

class FakerProduct extends FakerAbstractOrder
{
    // вставить 100 фейковых товаров в БД
    public function insertFakerData()
    {
        $allCategories = Category::getAllCategories();
        $allBrands = Brand::getAllBrands();
        $allCountries = CountryManufacturer::getAllCountryManufacturers();

        for ($i = 1; $i <= 100; $i++) {
            $product_name = "товар $i";
            $price = rand(500, 1500);
            $discount = rand(0, 200);
            $id_category = array_rand($allCategories) + 1;
            $id_brand = array_rand($allBrands) + 1;
            $id_manufacturer_сountry = array_rand($allCountries) + 1;

            $conn = DatabaseConnection::getInstance();
            $query = "INSERT INTO `products`(`product_name`, `price`, `discount`, `id_category`, `id_brand`, `id_manufacturer_сountry`) VALUES (?, ?, ?, ?, ?, ?)";
            $prepare = $conn->prepare($query);
            $prepare->execute([$product_name, $price, $discount, $id_category, $id_brand, $id_manufacturer_сountry]);
        }
    }
}