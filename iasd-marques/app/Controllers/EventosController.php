<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Models\Evento;
use App\Models\Asistente;

class EventosController extends Controller
{
    public function index(): void
    {
        Auth::authorize(['admin','editor','viewer']);
        $page = max(1, (int)($_GET['page'] ?? 1));
        $model = new Evento($this->config);
        $result = $model->paginate($page, 10);
        $this->view('eventos/index.php', [
            'items' => $result['items'],
            'total' => $result['total'],
            'page' => $page,
            'perPage' => 10,
        ]);
    }

    public function create(): void
    {
        Auth::authorize(['admin','editor']);
        $msg = null; $error = null;
        if ($this->isPost()) {
            $this->csrfVerify();
            $data = [
                'titulo' => trim($_POST['titulo'] ?? ''),
                'tipo' => $_POST['tipo'] ?? 'regular',
                'fecha' => $_POST['fecha'] ?? '',
                'hora' => $_POST['hora'] ?? '',
                'lugar' => trim($_POST['lugar'] ?? ''),
                'notas' => trim($_POST['notas'] ?? ''),
            ];
            if ($data['titulo'] === '' || $data['fecha'] === '' || $data['hora'] === '' || $data['lugar'] === '') {
                $error = 'Complete los campos obligatorios';
            } else {
                $id = (new Evento($this->config))->create($data);
                $msg = 'Evento creado con ID ' . $id;
            }
        }
        $this->view('eventos/create.php', compact('msg', 'error'));
    }

    public function asistencia(int $id): void
    {
        Auth::authorize(['admin','editor']);
        $eventoModel = new Evento($this->config);
        $evento = $eventoModel->find($id);
        if (!$evento) { http_response_code(404); exit('No encontrado'); }
        if ($this->isPost()) {
            $this->csrfVerify();
            foreach (($_POST['presente'] ?? []) as $asistenteId => $val) {
                $eventoModel->markAttendance($id, (int)$asistenteId, $val === '1');
            }
        }
        $asistentes = $eventoModel->attendanceList($id);
        $this->view('eventos/asistencia.php', compact('evento', 'asistentes'));
    }

    public function exportarCsv(int $id): void
    {
        Auth::authorize(['admin','editor','viewer']);
        $eventoModel = new Evento($this->config);
        $evento = $eventoModel->find($id);
        if (!$evento) { http_response_code(404); exit('No encontrado'); }
        $csv = $eventoModel->exportAttendanceCsv($id);
        header('Content-Type: text/csv; charset=utf-8');
        header('Content-Disposition: attachment; filename="asistencia_evento_' . $id . '.csv"');
        echo $csv;
        exit;
    }
}

