<?php


namespace Project\Controllers;

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Project\Models\Brand;
use Project\Models\Category;
use Project\Models\Report\ReportSalesBrand;
use Project\Models\Report\ReportSalesCategory;
use Project\Models\ReportExcel\ReportExcelSalesBrand;
use Project\Models\ReportExcel\ReportExcelSalesCategory;
use Project\Models\Shop;

class ReportSalesBrandController extends ReportAbstractController
{
    protected function generateReport()
    {
        $criterias = ReportSalesBrand::getCorrectCriteriasByFilter($_POST['criterias'] ?? null);       // получить корректный формат критериев для фильтров аналитики
        $shops = Shop::getCorrectFormatShops($_POST['id_shop'] ?? null);                                   // получить корректный формат магазинов для фильтров аналитики
        $date = ReportSalesBrand::getCorrectDateByFilter($_POST['date'] ?? '10/01/2020 - 10/31/2020');       // получить корректную дату для выборки из БД
        $brands = Brand::getCorrectBrandsByFilter($_POST['brands'] ?? null);

        $sales = ReportSalesBrand::getDetailInfoBySales($shops['shopsFromDB'], $criterias, $date['dateFrom'], $date['dateTo'], $brands['brandsFromDB']); // получить детальную инфомацию о заказах за выбранный период

        return [
            'criterias' => $criterias,
            'shops' => $shops,
            'date' => $date,
            'brands' => $brands,
            'sales' => $sales,
        ];
    }

    public function getReportByView()
    {
        $this->title = 'Продажи по магазинах';
        $info = $this->generateReport();

        return $this->render('sales-brand/content', [
            'sales' => $info['sales'],                                                                              // детальная информация о заказах
            'date' => $_POST['date'] ?? '10/01/2020 - 10/31/2020',                                                  // установить дату по умолчанию для фильтра (или ту дату которую пользователь выбрал)
            'shops' => Shop::getAllShop(),                                                                          // все магазины для фильтра
            'checkShops' => $info['shops']['shopsFromView'],                                                        // выбранные магазины (если ничего не выбрано, то выберутся все магазины)
            'checkCriterias' => $_POST['criterias'] ?? array_flip(ReportSalesCategory::$filterСriteriasByOrder),     // выбранные критерии (если ничего не выбрано, то берем все критерии)
            'brands' => Brand::getAllBrands(),                                                                      // выбрать все бренды
            'checkBrands' => $info['brands']['brandsFromView'],                                                     // выбранные бренды (если ничего не выбрано, то выберутся все бренды)
        ]);
    }

    public function downloadReportInExcel()
    {
        $info = $this->generateReport();                     // получаем отчет о продажах
        $report = (array)$info['sales'];                     // беремо только продажи и форматируем в массив

        $obj = new ReportExcelSalesBrand();                // создаем екземпляр класса
        $spreadsheet = $obj->fillCellInExcel($report);       // заполняем ексель данными

        $writer = new Xlsx($spreadsheet);
        $writer->save('sales-brand.xlsx');        // загружаем готовый ексель

        header("location: " . $_SERVER['HTTP_REFERER']);
    }
}