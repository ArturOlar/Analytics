<?php

namespace Project\Models\ReportExcel;


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Project\Models\Report\ReportSales;

class ReportExcelSalesProduct extends ReportAbstractExcel
{
    // заполняем ексель значениями
    public function fillCellInExcel($report)
    {
        unset($this->metric['count_orders'], $this->metric['date']);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $y = 1; // вертикальная координата (1, 2, 3, 4 и тд);

        // запускаем цикл, который проходит по каждой метрике, и проверяет существует ли она в отчете
        foreach ($this->metric as $key => $value) {

            if (ReportSales::checkPropertyExists($report, $key)) {
                $x = 1; // горизонтальная координата (A, B, C, D и тд);

                // заполняем первый столбец с названием метрики (кол-во заказов, оборот и тд)
                $sheet->setCellValueByColumnAndRow($y, $x, $this->metric[$key]);
                $x++;

                // заполняем значение каждой ячейки (значения заказов, значения оборота и тд)
                for ($i = 0; $i < count($report); $i++) {
                    $sheet->setCellValueByColumnAndRow($y, $x, $report[$i]->$key);
                    $x++;
                }
                $y++;
            }
        }
        // деляем автоширину для первого столбца и деляем его жирным
        $spreadsheet->getActiveSheet()->getColumnDimensionByColumn(1)->setAutoSize(true);
        $spreadsheet->getActiveSheet()->getStyle('1:1')->getFont()->setBold(true);
        return $spreadsheet;
    }
}