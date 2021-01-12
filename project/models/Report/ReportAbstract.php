<?php


namespace Project\Models\Report;

use Core\Model;

abstract class ReportAbstract extends Model
{
    /*
     * форматирование метрик которые выбрал пользовател в форме, в корректный запрос к БД
     * пример: пользовател выбрал 'count', форматируем в 'COUNT(DISTINCT(orders.id_order)) as 'count_orders' '
     */
    abstract public static function getCorrectCriteriasByFilter($selectСriterias);

    /*
     * массив из ключем (значение метрики которые есть в форме) и значением (корректный запрос к БД)
     * используется для работы метода getCorrectMetricsByFilter
     */
    public static $filterСriteriasByOrder = [
        "category" => "categories.category ",
        "brand" => "brand.brand ",
        "country" => "manufacturer_countries.country ",
        "count_product" => "SUM(orders_product.count) as `count_product` ",
        "sum" => "SUM(orders_product.final_price * orders_product.count) as `sum` ",
        "avg" => "SUM(orders_product.final_price * orders_product.count) / COUNT(DISTINCT(orders.id_order)) as `avg` ",
        "discount" => "SUM(orders_product.discount * orders_product.count) as `discount` ",
        "profit" => "SUM(orders_product.profit * orders_product.count) as `profit` ",
        "cost_price" => "SUM(orders_product.cost_price * orders_product.count) as `cost_price` ",
        "count" => "COUNT(DISTINCT(orders.id_order)) as `count_orders` ",
    ];

    /*
     * массив из запросами для выборки разрезов даты из БД
     */
    public static $timeSlice = [
        'week' => [
            'select' => "SELECT WEEKOFYEAR(orders.date_sale) as `date`, ",
            'groupBy' => "GROUP BY WEEKOFYEAR(orders.date_sale) ",
        ],
        'month' => [
            'select' => "SELECT MONTH(orders.date_sale) as `date`, ",
            'groupBy' => "GROUP BY MONTH(orders.date_sale) ",
        ],
        'day' => [
            'select' => "SELECT orders.date_sale as `date`, ",
            'groupBy' => "GROUP BY orders.date_sale ",
        ],
    ];

    /*
     * форматирование разреза времени которое выбрал пользовател в форме, в корректный запрос к БД
     * пример: пользовател выбрал 'week', форматируем в
     * 'select' => "SELECT WEEKOFYEAR(orders.date_sale) as 'date', "
     * 'groupBy' => "GROUP BY WEEKOFYEAR(orders.date_sale) "
     */
    public static function getCorrectTimeSlice($timeSlice)
    {
        $result = [];
        foreach (self::$timeSlice as $key => $value) {
            if ($key == $timeSlice) {
                $result['select'] = $value['select'];
                $result['groupBy'] = $value['groupBy'];
            }
        }
        return $result;
    }

    /*
     * форматирование периода которые выбрал пользовател в форме, в корректный запрос к БД
     * пример: пользовател выбрал '01/10/2020 - 15/10/2020', форматируем в $dateFrom = '01-10-2020', $dateTo = '15-10-2020' '
     */
    public static function getCorrectDateByFilter($date)
    {
        $date = explode('-', $date);

        $dateTime = new \DateTime($date[0]);
        $dateRes['dateFrom'] = $dateTime->format('Y-m-d');

        $dateTime = new \DateTime($date[1]);
        $dateRes['dateTo'] = $dateTime->format('Y-m-d');

        return $dateRes;
    }
}