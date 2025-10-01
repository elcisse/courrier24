<?php
namespace App\Controllers;

class ServiceController extends BaseController
{
    public function index(): void
    {
        $title = 'Services';
        $contentView = 'services/list';
        $this->render($contentView, compact('title'));
    }
}
