<?php


namespace Project\Models\Report;


use Project\Models\DatabaseConnection;

class ReportSalesShop extends ReportAbstract
{
    /*
     * сформировать запрос для полученияинформации о продажах по выбраных критериях
     */
    public static function getDetailInfoBySales($shops, $criterias, $dateFrom, $dateTo)
    {
        $conn = DatabaseConnection::getInstance();
        $query = "SELECT shops.shop_name, ";
        $query .= $criterias;
        $query .= "FROM orders_product ";
        $query .= "INNER JOIN orders ON orders.id_order = orders_product.id_order ";
        $query .= "INNER JOIN shops ON shops.id = orders.id_shop ";
        $query .= "WHERE orders.date_sale BETWEEN '$dateFrom' AND '$dateTo'";
        $query .= "AND id_shop IN ($shops) ";
        $query .= "GROUP BY shops.shop_name";

        $query = $conn->query($query);
        return $query->fetchAll(\PDO::FETCH_CLASS);
    }

    /*
     * форматирование метрик которые выбрал пользовател в форме, в корректный запрос к БД
     * пример: пользовател выбрал 'count', форматируем в 'COUNT(DISTINCT(orders.id_order)) as 'count_orders' '
     */
    public static function getCorrectCriteriasByFilter($selectСriterias)
    {
        unset(self::$filterСriteriasByOrder['brand'],self::$filterСriteriasByOrder['country'],self::$filterСriteriasByOrder['category']);
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