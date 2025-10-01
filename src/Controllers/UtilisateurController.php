<?php
namespace App\Controllers;

class UtilisateurController extends BaseController
{
    public function index(): void
    {
        $title = 'Utilisateurs';
        $contentView = 'utilisateurs/list';
        $this->render($contentView, compact('title'));
    }
}
