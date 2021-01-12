<?php
namespace Core;

class Model
{
    // проверить по ключу, есть ли в массиве из обьектов свойство из определленым ключем
    public static function checkPropertyExists($arrayObj, $property)
    {
        foreach ($arrayObj as $key => $value) {
            if (isset($value->$property) == $property) {
                return true;
            }
        }
        return false;
    }
}
