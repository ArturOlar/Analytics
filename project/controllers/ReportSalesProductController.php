<?php


namespace Project\Controllers;

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Project\Models\Brand;
use Project\Models\Category;
use Project\Models\CountryManufacturer;
use Project\Models\Report\ReportSalesProduct;
use Project\Models\ReportExcel\ReportExcelSalesProduct;
use Project\Models\Shop;

class ReportSalesProductController extends ReportAbstractController
{
    protected function generateReport()
    {
        $criterias = ReportSalesProduct::getCorrectCriteriasByFilter($_POST['criterias'] ?? null);       // получить корректный формат критериев для фильтров аналитики
        $shops = Shop::getCorrectFormatShops($_POST['id_shop'] ?? null);                                   // получить корректный формат магазинов для фильтров аналитики
        $date = ReportSalesProduct::getCorrectDateByFilter($_POST['date'] ?? '10/01/2020 - 10/31/2020');        // получить корректную дату для выборки из БД
        $categories = Category::getCorrectCategoriesByFilter($_POST['categories'] ?? null);
        $brands = Brand::getCorrectBrandsByFilter($_POST['brands'] ?? null);
        $country = CountryManufacturer::getCorrectCountriesByFilter($_POST['countries'] ?? null);

        $sales = ReportSalesProduct::getDetailInfoBySales($shops['shopsFromDB'], $criterias, $date['dateFrom'], $date['dateTo'], $categories['categoriesFromDB'], $brands['brandsFromDB'], $country['countriesFromDB']); // получить детальную инфомацию о заказах за выбранный период

        return [
            'criterias' => $criterias,
            'shops' => $shops,
            'date' => $date,
            'categories' => $categories,
            'brands' => $brands,
            'country' => $country,
            'sales' => $sales,
        ];

    }

    public function getReportByView()
    {
        $this->title = 'Продажи товаров';
        $info = $this->generateReport();

        return $this->render('orders-product/content', [
            'sales' => $info['sales'],                                                                              // детальная информация о заказах
            'date' => $_POST['date'] ?? '10/01/2020 - 10/31/2020',                                                  // установить дату по умолчанию для фильтра
            'shops' => Shop::getAllShop(),                                                                          // все магазины для фильтра
            'checkShops' => $info['shops']['shopsFromView'],                                                        // выбранные магазины
            'checkCriterias' => $_POST['criterias'] ?? array_flip(ReportSalesProduct::$filterСriteriasByOrder),     // выбранные критерии (если ничего не выбрано, то берем все критерии)
            'categories' => Category::getAllCategories(),                                                           // выбрать все категории
            'checkCategory' => $info['categories']['categoriesFromView'],                                           // выбранные категории
            'brands' => Brand::getAllBrands(),                                                                      // выбрать все бренды
            'checkBrands' => $info['brands']['brandsFromView'],                                                     // выбранные бренды
            'countries' => CountryManufacturer::getAllCountryManufacturers(),                                       // выбрать все страны производители
            'checkCountries' => $info['country']['countriesFromView'],                                              // выбранные страны-производители
        ]);
    }

    public function downloadReportInExcel()
    {
        $info = $this->generateReport();                    // получаем отчет о продажах
        $report = (array)$info['sales'];                     // берем только продажи и форматируем в массив

        $obj = new ReportExcelSalesProduct();                // создаем екземпляр класса
        $spreadsheet = $obj->fillCellInExcel($report);       // заполняем ексель данными

        $writer = new Xlsx($spreadsheet);
        $writer->save('sales-product.xlsx');        // загружаем готовый ексель

        header("location: " . $_SERVER['HTTP_REFERER']);
    }
}