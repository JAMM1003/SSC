<?php
declare(strict_types=1);

namespace App\Core;

class Controller
{
    protected array $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    protected function view(string $template, array $data = []): void
    {
        $basePath = dirname(__DIR__, 2) . '/app/Views/';
        $header = $basePath . 'layout/header.php';
        $footer = $basePath . 'layout/footer.php';
        $file = $basePath . $template;
        extract($data, EXTR_SKIP);
        $baseUrl = $this->config['app']['base_url'] ?? '/iasd-marques/public';
        include $header;
        include $file;
        include $footer;
    }

    protected function redirect(string $path): void
    {
        $baseUrl = rtrim($this->config['app']['base_url'] ?? '', '/');
        header('Location: ' . $baseUrl . $path);
        exit;
    }

    protected function isPost(): bool
    {
        return ($_SERVER['REQUEST_METHOD'] ?? 'GET') === 'POST';
    }

    protected function csrfVerify(): void
    {
        $token = $_POST['csrf_token'] ?? '';
        if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
            http_response_code(419);
            exit('Token CSRF inválido');
        }
    }
}

