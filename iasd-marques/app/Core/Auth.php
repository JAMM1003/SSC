<?php
declare(strict_types=1);

namespace App\Core;

use App\Models\Usuario;

class Auth
{
    public static function check(): bool
    {
        return isset($_SESSION['user']);
    }

    public static function user(): ?array
    {
        return $_SESSION['user'] ?? null;
    }

    public static function attempt(array $config, string $email, string $password): bool
    {
        $usuarioModel = new Usuario($config);
        $user = $usuarioModel->findByEmail($email);
        if ($user && (int)$user['activo'] === 1 && password_verify($password, $user['pass_hash'])) {
            session_regenerate_id(true);
            $_SESSION['user'] = [
                'id' => (int)$user['id'],
                'nombre' => $user['nombre'],
                'email' => $user['email'],
                'rol' => $user['rol'],
            ];
            return true;
        }
        return false;
    }

    public static function logout(): void
    {
        $_SESSION = [];
        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
        }
        session_destroy();
    }

    public static function authorize(array|string $roles): void
    {
        if (!self::check()) {
            http_response_code(302);
            header('Location: ' . ($_SERVER['BASE_URL'] ?? '/iasd-marques/public') . '/login');
            exit;
        }
        $roles = is_array($roles) ? $roles : [$roles];
        $user = self::user();
        if (!$user || !in_array($user['rol'], $roles, true)) {
            http_response_code(403);
            exit('Acceso denegado');
        }
    }
}

