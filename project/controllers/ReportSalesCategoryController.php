<?php
namespace Project\Controllers;

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Project\Models\Category;
use Project\Models\Report\ReportSalesCategory;
use Project\Models\ReportExcel\ReportExcelSalesCategory;
use Project\Models\ReportExcel\ReportExcelSalesProduct;
use Project\Models\Shop;

class ReportSalesCategoryController extends ReportAbstractController
{
    protected function generateReport()
    {
        $criterias = ReportSalesCategory::getCorrectCriteriasByFilter($_POST['criterias'] ?? null);       // получить корректный формат критериев для фильтров аналитики
        $shops = Shop::getCorrectFormatShops($_POST['id_shop'] ?? null);                                   // получить корректный формат магазинов для фильтров аналитики
        $date = ReportSalesCategory::getCorrectDateByFilter($_POST['date'] ?? '10/01/2020 - 10/31/2020');       // получить корректную дату для выборки из БД
        $categories = Category::getCorrectCategoriesByFilter($_POST['categories'] ?? null);

        $sales = ReportSalesCategory::getDetailInfoBySales($shops['shopsFromDB'], $criterias, $date['dateFrom'], $date['dateTo'], $categories['categoriesFromDB']); // получить детальную инфомацию о заказах за выбранный период

        return [
            'criterias' => $criterias,
            'shops' => $shops,
            'date' => $date,
            'categories' => $categories,
            'sales' => $sales,
        ];
    }

    public function getReportByView()
    {
        $this->title = 'Продажи по магазинах';
        $info = $this->generateReport();

        return $this->render('sales-category/content', [
            'sales' => $info['sales'],                                                                              // детальная информация о заказах
            'date' => $_POST['date'] ?? '10/01/2020 - 10/31/2020',                                                  // установить дату по умолчанию для фильтра (или ту дату которую пользователь выбрал)
            'shops' => Shop::getAllShop(),                                                                          // все магазины для фильтра
            'checkShops' => $info['shops']['shopsFromView'],                                                        // выбранные магазины (если ничего не выбрано, то выберутся все магазины)
            'checkCriterias' => $_POST['criterias'] ?? array_flip(ReportSalesCategory::$filterСriteriasByOrder),     // выбранные критерии (если ничего не выбрано, то берем все критерии)
            'categories' => Category::getAllCategories(),                                                           // выбрать все категории
            'checkCategory' => $info['categories']['categoriesFromView'],                                           // выбранные категории (если ничего не выбрано, то выберутся все категории)
        ]);
    }

    public function downloadReportInExcel()
    {
        $info = $this->generateReport();                     // получаем отчет о продажах
        $report = (array)$info['sales'];                     // беремо только продажи и форматируем в массив

        $obj = new ReportExcelSalesCategory();                // создаем екземпляр класса
        $spreadsheet = $obj->fillCellInExcel($report);       // заполняем ексель данными

        $writer = new Xlsx($spreadsheet);
        $writer->save('sales-category.xlsx');        // загружаем готовый ексель

        header("location: " . $_SERVER['HTTP_REFERER']);
    }
}