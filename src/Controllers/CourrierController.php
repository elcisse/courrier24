<?php
namespace App\Controllers;

use App\Database\Connection;
use Respect\Validation\Validator as v;

class CourrierController extends BaseController
{
    public function index(): void
    {
        $pdo = Connection::make();
        $rows = $pdo->query("
            SELECT c.id, c.type, c.ref, c.objet, c.statut, c.created_at, s.libelle AS service_cible
            FROM courriers c
            LEFT JOIN services s ON s.id = c.service_cible_id
            ORDER BY c.created_at DESC
            LIMIT 200
        ")->fetchAll();

        $title = 'Courriers';
        $contentView = 'courriers/list';
        $this->render($contentView, compact('title','rows'));
    }

    public function create(): void
    {
        $pdo = Connection::make();
        $services = $pdo->query("SELECT id, libelle FROM services WHERE actif=1 ORDER BY libelle")->fetchAll();

        $title = 'Nouveau courrier';
        $contentView = 'courriers/form';
        $this->render($contentView, compact('title','services'));
    }

    public function store(): void
    {
        $type = $_POST['type'] ?? 'ENTRANT';
        $objet = trim($_POST['objet'] ?? '');
        $service_cible_id = (int)($_POST['service_cible_id'] ?? 0);
        $date_reception = $_POST['date_reception'] ?? null;
        $date_envoi = $_POST['date_envoi'] ?? null;

        if (!in_array($type, ['ENTRANT','SORTANT'], true) ||
            !v::stringType()->length(2, 255)->validate($objet) ||
            $service_cible_id <= 0) {
            $_SESSION['flash_error'] = "Champs invalides.";
            redirect(url('/courriers/create'));
        }

        // Contrôle des dates selon type
        if ($type === 'ENTRANT' && empty($date_reception)) {
            $_SESSION['flash_error'] = "La date de réception est requise pour un courrier entrant.";
            redirect(url('/courriers/create'));
        }
        if ($type === 'SORTANT' && empty($date_envoi)) {
            $_SESSION['flash_error'] = "La date d'envoi est requise pour un courrier sortant.";
            redirect(url('/courriers/create'));
        }

        $pdo = Connection::make();
        $ref = generate_courrier_ref($service_cible_id);

        $stmt = $pdo->prepare("
            INSERT INTO courriers(type, ref, objet, service_cible_id, statut, created_by, date_reception, date_envoi)
            VALUES(:t, :r, :o, :sid, 'ENREGISTRE', :uid, :dr, :de)
        ");
        $stmt->execute([
            ':t'   => $type,
            ':r'   => $ref,
            ':o'   => $objet,
            ':sid' => $service_cible_id,
            ':uid' => auth_user_id(),
            ':dr'  => $date_reception ?: null,
            ':de'  => $date_envoi ?: null,
        ]);

        redirect(url('/courriers'));
    }
}
