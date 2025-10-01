<?php
namespace App\Controllers;

use App\Database\Connection;
use Respect\Validation\Validator as v;

class ServiceController extends BaseController
{
    public function index(): void
    {
        $pdo = Connection::make();
        $rows = $pdo->query("SELECT id, code, libelle, actif FROM services ORDER BY libelle")->fetchAll();
        $title = 'Services';
        $contentView = 'services/list';
        $this->render($contentView, compact('title','rows'));
    }

    public function create(): void
    {
        $title = 'Nouveau service';
        $contentView = 'services/form';
        $row = ['id'=>null,'code'=>'','libelle'=>'','actif'=>1];
        $this->render($contentView, compact('title','row'));
    }

    public function store(): void
    {
        $data = [
            'code'    => strtoupper(trim($_POST['code'] ?? '')),
            'libelle' => trim($_POST['libelle'] ?? ''),
            'actif'   => isset($_POST['actif']) ? 1 : 0,
        ];

        if (!v::alnum('-_')->length(2,30)->validate($data['code']) ||
            !v::stringType()->length(2,150)->validate($data['libelle'])) {
            $_SESSION['flash_error'] = "Champs invalides.";
            redirect(url('/services/create'));
        }

        $pdo = Connection::make();
        $stmt = $pdo->prepare("INSERT INTO services(code, libelle, actif) VALUES(:c,:l,:a)");
        $stmt->execute([':c'=>$data['code'], ':l'=>$data['libelle'], ':a'=>$data['actif']]);
        redirect(url('/services'));
    }

    public function edit(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $pdo = Connection::make();
        $stmt = $pdo->prepare("SELECT * FROM services WHERE id=:id");
        $stmt->execute([':id'=>$id]);
        $row = $stmt->fetch();
        if (!$row) { http_response_code(404); include BASE_PATH . '/src/Views/errors/404.php'; return; }

        $title = 'Modifier service';
        $contentView = 'services/form';
        $this->render($contentView, compact('title','row'));
    }

    public function update(): void
    {
        $id = (int)($_POST['id'] ?? 0);
        $data = [
            'code'    => strtoupper(trim($_POST['code'] ?? '')),
            'libelle' => trim($_POST['libelle'] ?? ''),
            'actif'   => isset($_POST['actif']) ? 1 : 0,
        ];
        $pdo = Connection::make();
        $stmt = $pdo->prepare("UPDATE services SET code=:c, libelle=:l, actif=:a WHERE id=:id");
        $stmt->execute([':c'=>$data['code'],':l'=>$data['libelle'],':a'=>$data['actif'],':id'=>$id]);
        redirect(url('/services'));
    }

    public function destroy(): void
    {
        $id = (int)($_POST['id'] ?? 0);
        $pdo = Connection::make();
        $stmt = $pdo->prepare("DELETE FROM services WHERE id=:id");
        $stmt->execute([':id'=>$id]);
        redirect(url('/services'));
    }
}
