<?php


namespace Project\Models\Report;

use Project\Models\DatabaseConnection;

class ReportSales extends ReportAbstract
{
    /*
     * сформировать запрос для полученияинформации о продажах по выбраных критериях
     */
    public static function getDetailInfoBySales($shops, $criterias, $dateFrom, $dateTo, $selectTimeSlice, $groupByTimeSlice)
    {
        $conn = DatabaseConnection::getInstance();

        $query = "$selectTimeSlice ";
        $query .= "$criterias ";
        $query .= "FROM orders ";
        $query .= "INNER JOIN orders_product ON orders_product.id_order = orders.id_order ";
        $query .= "WHERE date_sale BETWEEN '$dateFrom' AND '$dateTo' ";
        $query .= "AND id_shop IN ($shops) ";
        $query .= "$groupByTimeSlice ";
        $query .= "ORDER BY 'date' ASC ";

        $query = $conn->query($query);
        return $query->fetchAll(\PDO::FETCH_CLASS);
    }

    /*
     * форматирование метрик которые выбрал пользовател в форме, в корректный запрос к БД
     * пример: пользовател выбрал 'count', форматируем в 'COUNT(DISTINCT(orders.id_order)) as 'count_orders' '
     */
    public static function getCorrectCriteriasByFilter($selectСriterias)
    {
        unset(self::$filterСriteriasByOrder['category'],self::$filterСriteriasByOrder['brand'],self::$filterСriteriasByOrder['country']);
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