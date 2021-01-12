<?php


namespace Project\Models\Faker;


use Core\Model;

abstract class FakerAbstractOrder extends Model
{
    abstract public function insertFakerData();
}