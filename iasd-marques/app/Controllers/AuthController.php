<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Models\Usuario;

class AuthController extends Controller
{
    public function redirectHome(): void
    {
        if (Auth::check()) {
            $this->redirect('/dashboard');
        } else {
            $this->redirect('/login');
        }
    }

    public function login(): void
    {
        $error = null;
        if ($this->isPost()) {
            $this->csrfVerify();
            $email = trim($_POST['email'] ?? '');
            $password = (string)($_POST['password'] ?? '');
            if (Auth::attempt($this->config, $email, $password)) {
                $this->redirect('/dashboard');
            } else {
                $error = 'Credenciales inválidas.';
            }
        }
        $this->view('auth/login.php', compact('error'));
    }

    public function logout(): void
    {
        Auth::logout();
        $this->redirect('/login');
    }

    public function forgot(): void
    {
        $msg = null; $error = null;
        if ($this->isPost()) {
            $this->csrfVerify();
            $email = trim($_POST['email'] ?? '');
            $usuarioModel = new Usuario($this->config);
            $user = $usuarioModel->findByEmail($email);
            if ($user) {
                $token = bin2hex(random_bytes(16));
                $expires = date('Y-m-d H:i:s', time() + 3600);
                $usuarioModel->createPasswordReset((int)$user['id'], $token, $expires);
                error_log('Password reset token for ' . $email . ': ' . $token);
                $msg = 'Se ha generado un token temporal. Revise los logs.';
            } else {
                $error = 'Si el correo existe, se enviará un token.';
            }
        }
        $this->view('auth/forgot.php', compact('msg', 'error'));
    }
}

