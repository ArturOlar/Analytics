<?php
namespace Project\Models;

use \Core\Model;
use Project\Models\DatabaseConnection;

class CountryManufacturer extends Model
{
    // получить все страны производители
    public static function getAllCountryManufacturers()
    {
        $conn = DatabaseConnection::getInstance();
        $query = $conn->query("SELECT * FROM manufacturer_countries");
        return $query->fetchAll(\PDO::FETCH_CLASS);
    }

    public static function getCorrectCountriesByFilter($countriesPOST)
    {
        if ($countriesPOST != null) {
            $countries = $countriesPOST;
            $country = implode(', ', $countries);
        } else {
            $countryObj = CountryManufacturer::getAllCountryManufacturers();
            foreach ($countryObj as $key => $value) {
                $countries[] = $value->id;
            }
            $country = implode(', ', $countries);
        }
        $res['countriesFromView'] = $countries;
        $res['countriesFromDB'] = $country;
        return $res;
    }
}