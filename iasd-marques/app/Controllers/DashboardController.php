<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Models\Asistente;
use App\Models\Evento;

class DashboardController extends Controller
{
    public function index(): void
    {
        Auth::authorize(['admin','editor','viewer']);
        $asistenteModel = new Asistente($this->config);
        $eventoModel = new Evento($this->config);

        $stats = [
            'total_asistentes' => (int)$this->count('asistentes'),
            'nuevos_interesados_mes' => (int)$this->count('asistentes', "estatus='nuevo_interesado' AND MONTH(created_at)=MONTH(CURDATE()) AND YEAR(created_at)=YEAR(CURDATE())"),
        ];
        $eventos = $eventoModel->allUpcoming();

        // Top intereses by simple query
        $pdo = (new Asistente($this->config));
        $pdo = (new \App\Core\Model($this->config));
        // quick counts for chart
        $kpis = $this->topIntereses();

        $this->view('dashboard.php', compact('stats', 'eventos', 'kpis'));
    }

    private function count(string $table, string $where = '1'): int
    {
        $m = new \App\Core\Model($this->config);
        $stmt = (new \ReflectionClass($m))->getProperty('pdo');
        $stmt->setAccessible(true);
        /** @var \PDO $pdo */
        $pdo = $stmt->getValue($m);
        $q = $pdo->query("SELECT COUNT(*) FROM $table WHERE $where");
        return (int)$q->fetchColumn();
    }

    private function topIntereses(): array
    {
        $m = new \App\Core\Model($this->config);
        $ref = new \ReflectionClass($m);
        $prop = $ref->getProperty('pdo');
        $prop->setAccessible(true);
        /** @var \PDO $pdo */
        $pdo = $prop->getValue($m);
        $sql = "SELECT i.nombre, COUNT(*) c FROM asistente_interes ai JOIN intereses i ON i.id=ai.interes_id GROUP BY i.id ORDER BY c DESC LIMIT 5";
        $rows = $pdo->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
        return $rows;
    }
}

