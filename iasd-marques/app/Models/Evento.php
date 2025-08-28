<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use PDO;

class Evento extends Model
{
    public function allUpcoming(): array
    {
        $stmt = $this->pdo->query("SELECT * FROM eventos WHERE fecha >= CURDATE() ORDER BY fecha ASC LIMIT 10");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function paginate(int $page = 1, int $perPage = 10): array
    {
        $offset = ($page - 1) * $perPage;
        $stmt = $this->pdo->query("SELECT SQL_CALC_FOUND_ROWS * FROM eventos ORDER BY fecha DESC, hora DESC LIMIT $perPage OFFSET $offset");
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $total = (int)$this->pdo->query('SELECT FOUND_ROWS()')->fetchColumn();
        return ['items' => $items, 'total' => $total];
    }

    public function find(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM eventos WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->pdo->prepare('INSERT INTO eventos (titulo, tipo, fecha, hora, lugar, notas) VALUES (?,?,?,?,?,?)');
        $stmt->execute([
            $data['titulo'], $data['tipo'], $data['fecha'], $data['hora'], $data['lugar'], $data['notas'] ?? null
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function markAttendance(int $eventoId, int $asistenteId, bool $presente, ?string $obs = null): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO asistencias (evento_id, asistente_id, presente, observacion) VALUES (?,?,?,?)
            ON DUPLICATE KEY UPDATE presente=VALUES(presente), observacion=VALUES(observacion)');
        $stmt->execute([$eventoId, $asistenteId, $presente ? 1 : 0, $obs]);
    }

    public function attendanceList(int $eventoId): array
    {
        $sql = 'SELECT a.id, a.nombre, a.apellido, a.telefono, COALESCE(s.presente, 0) presente
                FROM asistentes a
                LEFT JOIN asistencias s ON s.asistente_id=a.id AND s.evento_id=?
                ORDER BY a.apellido, a.nombre';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$eventoId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function exportAttendanceCsv(int $eventoId): string
    {
        $rows = $this->attendanceList($eventoId);
        $fh = fopen('php://temp', 'w+');
        fputcsv($fh, ['ID','Nombre','Apellido','Telefono','Presente']);
        foreach ($rows as $r) {
            fputcsv($fh, [$r['id'], $r['nombre'], $r['apellido'], $r['telefono'], $r['presente'] ? 'SI' : 'NO']);
        }
        rewind($fh);
        return stream_get_contents($fh) ?: '';
    }
}

