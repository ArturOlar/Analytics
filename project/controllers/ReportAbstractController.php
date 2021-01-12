<?php

namespace Project\Controllers;

use \Core\Controller;

abstract class ReportAbstractController extends Controller
{
    // згенерировать отчет
    abstract protected function generateReport();

    // рендер отчета в шаблон
    abstract public function getReportByView();

    // рендер отчета в excel
    abstract public function downloadReportInExcel();
}