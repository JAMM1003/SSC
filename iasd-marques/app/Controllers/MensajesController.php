<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Models\Mensaje;
use App\Models\Asistente;

class MensajesController extends Controller
{
    public function plantillas(): void
    {
        Auth::authorize(['admin','editor']);
        $msg = null; $error = null;
        $model = new Mensaje($this->config);
        if ($this->isPost()) {
            $this->csrfVerify();
            $nombre = trim($_POST['nombre'] ?? '');
            $cuerpo = trim($_POST['cuerpo'] ?? '');
            if ($nombre === '' || $cuerpo === '') {
                $error = 'Complete nombre y cuerpo';
            } else {
                $model->createTemplate($nombre, $cuerpo);
                $msg = 'Plantilla creada';
            }
        }
        $items = $model->listTemplates();
        $this->view('mensajes/plantillas.php', compact('items', 'msg', 'error'));
    }

    public function cola(): void
    {
        Auth::authorize(['admin','editor']);
        $msg = null; $error = null;
        $mensajeModel = new Mensaje($this->config);
        if ($this->isPost()) {
            $this->csrfVerify();
            $asistenteId = (int)($_POST['asistente_id'] ?? 0);
            $plantillaId = (int)($_POST['plantilla_id'] ?? 0);
            $fecha = trim($_POST['fecha_programada'] ?? '');
            if ($asistenteId && $plantillaId && $fecha) {
                $mensajeModel->queueMessage($asistenteId, $plantillaId, $fecha);
                $msg = 'Mensaje programado';
            } else {
                $error = 'Complete todos los campos';
            }
        }
        // For form selects
        $asistentes = (new Asistente($this->config))->paginate('', '', 1, 100)['items'];
        $plantillas = $mensajeModel->listTemplates();
        $pendientes = $mensajeModel->pendingQueue();
        $this->view('mensajes/cola.php', compact('asistentes','plantillas','pendientes','msg','error'));
    }

    public function procesarCola(): void
    {
        Auth::authorize(['admin','editor']);
        $mensajeModel = new Mensaje($this->config);
        $pendientes = $mensajeModel->pendingQueue();
        $logPath = dirname(__DIR__, 2) . '/logs/app.log';
        foreach ($pendientes as $p) {
            $texto = $p['plantilla_texto'];
            $texto = str_replace(['{{nombre}}','{{evento}}','{{fecha}}'], [
                $p['nombre'], $p['plantilla_id'] ?? '', date('d/m/Y')
            ], $texto);
            $waUrl = 'https://wa.me/' . rawurlencode($p['telefono']) . '?text=' . rawurlencode($texto);
            $mensajeModel->markSent((int)$p['id']);
            file_put_contents($logPath, '[' . date('c') . "] Cola WA ID {$p['id']} -> $waUrl\n", FILE_APPEND);
        }
        $this->redirect('/mensajes/cola');
    }
}

