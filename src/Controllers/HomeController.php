<?php
namespace App\Controllers;

class HomeController extends BaseController
{
    public function index(): void
    {
        $title = 'Tableau de bord';
        $contentView = 'dashboard/index';
        $this->render($contentView, compact('title'));
    }
}
