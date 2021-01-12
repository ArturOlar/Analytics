<?php

namespace Project\Controllers;

require 'vendor/autoload.php';

use Project\Models\Report\ReportSales;
use Project\Models\ReportExcel\ReportExcelSales;
use Project\Models\Shop;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ReportSalesController extends ReportAbstractController
{
    // згенерировать отчет
    protected function generateReport()
    {
        $criterias = ReportSales::getCorrectCriteriasByFilter($_POST['criterias'] ?? null);    // получить корректный формат критериев для фильтров аналитики
        $shops = Shop::getCorrectFormatShops($_POST['id_shop'] ?? null);                        // получить корректный формат магазинов для фильтров аналитики
        $date = ReportSales::getCorrectDateByFilter($_POST['date'] ?? '10/01/2020 - 10/31/2020');    // получить корректную дату для выборки из БД
        $timeSlice = ReportSales::getCorrectTimeSlice($_POST['time-slice'] ?? 'week');           // получить массив коректнных данных по разрезу времени для выборки продаж из БД

        // получить детальную инфомацию о продажах за выбранный период
        $sales = ReportSales::getDetailInfoBySales($shops['shopsFromDB'], $criterias, $date['dateFrom'], $date['dateTo'], $timeSlice['select'], $timeSlice['groupBy']);

        return [
            'sales' => $sales,
            'criterias' => $criterias,
            'date' => $date,
            'timeSlice' => $timeSlice,
            'shops' => $shops,
        ];
    }

    // рендер отчета в шаблон
    public function getReportByView()
    {
        $this->title = 'Продажи';
        $info = $this->generateReport();                                                                    // получаем отчет

        return $this->render('orders/content', [
            'sales' => $info['sales'],                                                                      // детальная информация о заказах
            'date' => $_POST['date'] ?? '10/01/2020 - 10/31/2020',                                          // установить дату по умолчанию для фильтра
            'shops' => Shop::getAllShop(),                                                                  // все магазины для фильтра
            'checkShops' => $info['shops']['shopsFromView'],                                                // выбранные магазины (если ничего не выбрано, то выберутся все магазины)
            'checkCriterias' => $_POST['criterias'] ?? array_flip(ReportSales::$filterСriteriasByOrder),    // выбранные критерии (если ничего не выбрано, то берем все критерии)
            'timeSlice' => $_POST['time-slice'] ?? 'week',                                                  // выбранный разрез времени (по умолчанию разре 'неделя')
        ]);
    }

    // рендер отчета в excel
    public function downloadReportInExcel()
    {
        $info = $this->generateReport();                     // получаем отчет о продажах
        $report = (array)$info['sales'];                     // беремо только продажи и форматируем в массив
        $obj = new ReportExcelSales();                       // создаем екземпляр класса
        $spreadsheet = $obj->fillCellInExcel($report);       // заполняем ексель данными

        $writer = new Xlsx($spreadsheet);
        $writer->save('sales.xlsx');                // загружаем готовый ексель

        header("location: " . $_SERVER['HTTP_REFERER']);
    }
}
