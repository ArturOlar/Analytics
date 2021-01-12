<?php


namespace Project\Controllers;

use \Core\Controller;

class MainController extends Controller
{
    public function main()
    {
        $this->title = 'Главная';
        return $this->render('main/main');
    }
}