<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use PDO;

class Mensaje extends Model
{
    public function listTemplates(): array
    {
        $stmt = $this->pdo->query('SELECT * FROM plantillas_wa ORDER BY id DESC');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createTemplate(string $nombre, string $cuerpo): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO plantillas_wa (nombre, cuerpo_texto) VALUES (?,?)');
        $stmt->execute([$nombre, $cuerpo]);
    }

    public function queueMessage(int $asistenteId, int $plantillaId, string $fechaProgramada): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO wa_queue (asistente_id, plantilla_id, fecha_programada) VALUES (?,?,?)');
        $stmt->execute([$asistenteId, $plantillaId, $fechaProgramada]);
    }

    public function pendingQueue(): array
    {
        $stmt = $this->pdo->query("SELECT q.*, a.nombre, a.apellido, a.telefono, p.cuerpo_texto AS plantilla_texto
            FROM wa_queue q
            JOIN asistentes a ON a.id = q.asistente_id
            JOIN plantillas_wa p ON p.id = q.plantilla_id
            WHERE q.estado='pendiente' AND q.fecha_programada <= NOW()
            ORDER BY q.fecha_programada ASC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function markSent(int $id): void
    {
        $stmt = $this->pdo->prepare("UPDATE wa_queue SET estado='enviado', intento=intento+1 WHERE id=?");
        $stmt->execute([$id]);
    }
}

