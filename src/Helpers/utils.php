<?php
use App\Database\Connection;

function generate_courrier_ref(int $serviceId): string {
    $pdo = Connection::make();
    $pdo->beginTransaction();
    try {
        $year = (int)date('Y');

        // Récup code service
        $s = $pdo->prepare("SELECT code FROM services WHERE id=:id");
        $s->execute([':id'=>$serviceId]);
        $svc = $s->fetch();
        $code = $svc ? strtoupper($svc['code']) : 'GEN';

        // Lock le compteur
        $stmt = $pdo->prepare("SELECT last_number FROM ref_counters WHERE annee=:y AND service_id=:sid FOR UPDATE");
        $stmt->execute([':y'=>$year, ':sid'=>$serviceId]);
        $row = $stmt->fetch();

        if ($row) {
            $n = (int)$row['last_number'] + 1;
            $upd = $pdo->prepare("UPDATE ref_counters SET last_number=:n WHERE annee=:y AND service_id=:sid");
            $upd->execute([':n'=>$n, ':y'=>$year, ':sid'=>$serviceId]);
        } else {
            $n = 1;
            $ins = $pdo->prepare("INSERT INTO ref_counters(annee, service_id, last_number) VALUES(:y,:sid,:n)");
            $ins->execute([':y'=>$year, ':sid'=>$serviceId, ':n'=>$n]);
        }

        $ref = sprintf('%d/%s/%04d', $year, $code, $n);
        $pdo->commit();
        return $ref;
    } catch (\Throwable $e) {
        $pdo->rollBack();
        throw $e;
    }
}
