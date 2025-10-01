<?php
namespace App\Controllers;

class CourrierController extends BaseController
{
    public function index(): void
    {
        $title = 'Courriers';
        $contentView = 'courriers/list';
        $this->render($contentView, compact('title'));
    }
}
