<?php


namespace Project\Models\Report;

use Project\Models\DatabaseConnection;

class ReportSalesProduct extends ReportAbstract
{
    /*
     * сформировать запрос для полученияинформации о продажах по выбраных критериях
     */
    public static function getDetailInfoBySales($shops, $criterias, $dateFrom, $dateTo, $categories, $brands, $countries)
    {
        $conn = DatabaseConnection::getInstance();
        $query = "SELECT CONCAT(orders_product.id_product, ' || ', products.product_name) as 'name', ";
        $query .= $criterias;
        $query .= "FROM orders_product ";
        $query .= "INNER JOIN products ON products.id = orders_product.id_product ";
        $query .= "INNER JOIN orders ON orders.id_order = orders_product.id_order ";
        $query .= "INNER JOIN categories on categories.id = products.id_category ";
        $query .= "INNER JOIN brand on brand.id = products.id_brand ";
        $query .= "INNER JOIN manufacturer_countries on manufacturer_countries.id = products.id_manufacturer_сountry ";
        $query .= "WHERE orders.date_sale BETWEEN '$dateFrom' AND '$dateTo'";
        $query .= "AND id_shop IN ($shops) ";
        $query .= "AND categories.id IN($categories) ";
        $query .= "AND brand.id IN ($brands) ";
        $query .= "AND manufacturer_countries.id IN($countries) ";
        $query .= "GROUP BY id_product";

//        print_r($query); die();

        $query = $conn->query($query);
        return $query->fetchAll(\PDO::FETCH_CLASS);
    }

    /*
     * форматирование метрик которые выбрал пользовател в форме, в корректный запрос к БД
     * пример: пользовател выбрал 'count', форматируем в 'COUNT(DISTINCT(orders.id_order)) as 'count_orders' '
     */
    public static function getCorrectCriteriasByFilter($selectСriterias)
    {
        unset(self::$filterСriteriasByOrder['count']);
        $request = '';
        if ($selectСriterias == null) {
            foreach (self::$filterСriteriasByOrder as $key => $value) {
                $request .= $value . ',';
            }
        } else {
            foreach (self::$filterСriteriasByOrder as $key => $value) {
                if (in_array($key, $selectСriterias)) {
                    $request .= $value . ',';
                }
            }
        }
        return substr($request, 0, -1);
    }
}