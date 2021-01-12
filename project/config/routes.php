<?php
use \Core\Route;

return [
    new Route('/', 'Main', 'main'),

    new Route('/sales', 'ReportSales', 'getReportByView'),                          // отчет о продажах
    new Route('/sales-product', 'ReportSalesProduct', 'getReportByView'),           // отчет о проданных товарах
    new Route('/sales-shop', 'ReportSalesShop', 'getReportByView'),                 // отчет продаж по магазинах
    new Route('/sales-category', 'ReportSalesCategory', 'getReportByView'),         // отчет продаж по магазинах
    new Route('/sales-brand', 'ReportSalesBrand', 'getReportByView'),               // отчет продаж по магазинах

    new Route('/download-sales-excel', 'ReportSales', 'downloadReportInExcel'),                     // скачать отчет в ексель
    new Route('/download-sales-product-excel', 'ReportSalesProduct', 'downloadReportInExcel'),      // скачать отчет в ексель
    new Route('/download-sales-shop-excel', 'ReportSalesShop', 'downloadReportInExcel'),            // скачать отчет в ексель
    new Route('/download-sales-category-excel', 'ReportSalesCategory', 'downloadReportInExcel'),    // скачать отчет в ексель
    new Route('/download-sales-brand-excel', 'ReportSalesBrand', 'downloadReportInExcel'),          // скачать отчет в ексель

    new Route('/insert-faker-product', 'databaseFaker', 'insertFakerProduct'),                  // роутер страницы для заполнения фейковых товаров в БД
    new Route('/insert-faker-order', 'databaseFaker', 'insertFakerOrders'),                     // роутер страницы для заполнения фейковых заказов в БД
];