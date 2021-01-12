<?php

namespace Project\Models\ReportExcel;


abstract class ReportAbstractExcel
{
    protected $metric = [
        'name' => 'Код и наименование',
        'category' => 'Категория',
        'brand' => 'Бренд',
        'country' => 'Страна производитель',
        'shop_name' => 'Магазин',
        'date' => 'Период',
        'count_orders' => 'Кол-во чеков',
        'sum' => 'Оборот',
        'avg' => 'Средний чек',
        'discount' => 'Сделанная скидка',
        'profit' => 'Прибыль',
        'cost_price' => 'Себестоимость',
        'count_product' => 'Кол-во прод товаров',
    ];

    abstract public function fillCellInExcel($report);
}