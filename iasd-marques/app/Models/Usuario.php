<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\Model;
use PDO;

class Usuario extends Model
{
    public function findByEmail(string $email): ?array
    {
        $stmt = $this->pdo->prepare('SELECT * FROM usuarios WHERE email = ? LIMIT 1');
        $stmt->execute([$email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function createPasswordReset(int $usuarioId, string $token, string $expiresAt): void
    {
        $stmt = $this->pdo->prepare('INSERT INTO password_resets (usuario_id, token, expira_en) VALUES (?,?,?)');
        $stmt->execute([$usuarioId, $token, $expiresAt]);
    }

    public function findByResetToken(string $token): ?array
    {
        $stmt = $this->pdo->prepare('SELECT pr.*, u.email FROM password_resets pr JOIN usuarios u ON u.id=pr.usuario_id WHERE pr.token = ? AND pr.usado = 0 LIMIT 1');
        $stmt->execute([$token]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ?: null;
    }

    public function countUsers(): int
    {
        return (int)$this->pdo->query('SELECT COUNT(*) FROM usuarios')->fetchColumn();
    }

    public function createUser(string $nombre, string $email, string $password, string $rol = 'admin'): int
    {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->pdo->prepare('INSERT INTO usuarios (nombre, email, pass_hash, rol, activo) VALUES (?,?,?,?,1)');
        $stmt->execute([$nombre, $email, $hash, $rol]);
        return (int)$this->pdo->lastInsertId();
    }
}

