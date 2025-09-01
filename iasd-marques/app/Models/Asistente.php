<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use PDO;

class Asistente extends Model
{
    public function paginate(string $q = '', string $estatus = '', int $page = 1, int $perPage = 10): array
    {
        $where = [];
        $params = [];
        if ($q !== '') {
            $where[] = '(nombre LIKE ? OR apellido LIKE ?)';
            $params[] = "%$q%"; $params[] = "%$q%";
        }
        if ($estatus !== '') {
            $where[] = 'estatus = ?';
            $params[] = $estatus;
        }
        $sqlWhere = $where ? ('WHERE ' . implode(' AND ', $where)) : '';
        $offset = ($page - 1) * $perPage;
        $stmt = $this->pdo->prepare("SELECT SQL_CALC_FOUND_ROWS * FROM asistentes $sqlWhere ORDER BY created_at DESC LIMIT $perPage OFFSET $offset");
        $stmt->execute($params);
        $items = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $total = (int)$this->pdo->query('SELECT FOUND_ROWS()')->fetchColumn();
        return ['items' => $items, 'total' => $total];
    }

    public function find(int $id): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM asistentes WHERE id = ?');
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function create(array $data): int
    {
        $stmt = $this->pdo->prepare('INSERT INTO asistentes (nombre, apellido, telefono, email, edad, sexo, direccion, estatus, notas) VALUES (?,?,?,?,?,?,?,?,?)');
        $stmt->execute([
            $data['nombre'], $data['apellido'], $data['telefono'] ?? null, $data['email'] ?? null,
            $data['edad'] ?? null, $data['sexo'] ?? null, $data['direccion'] ?? null,
            $data['estatus'] ?? 'visitante', $data['notas'] ?? null
        ]);
        return (int)$this->pdo->lastInsertId();
    }

    public function updateById(int $id, array $data): void
    {
        $stmt = $this->pdo->prepare('UPDATE asistentes SET nombre=?, apellido=?, telefono=?, email=?, edad=?, sexo=?, direccion=?, estatus=?, notas=? WHERE id=?');
        $stmt->execute([
            $data['nombre'], $data['apellido'], $data['telefono'] ?? null, $data['email'] ?? null,
            $data['edad'] ?? null, $data['sexo'] ?? null, $data['direccion'] ?? null,
            $data['estatus'] ?? 'visitante', $data['notas'] ?? null, $id
        ]);
    }
}

