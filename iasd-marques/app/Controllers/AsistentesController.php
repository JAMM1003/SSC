<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Auth;
use App\Models\Asistente;

class AsistentesController extends Controller
{
    public function index(): void
    {
        Auth::authorize(['admin','editor','viewer']);
        $q = trim($_GET['q'] ?? '');
        $estatus = trim($_GET['estatus'] ?? '');
        $page = max(1, (int)($_GET['page'] ?? 1));
        $model = new Asistente($this->config);
        $result = $model->paginate($q, $estatus, $page, 10);
        $this->view('asistentes/index.php', [
            'items' => $result['items'],
            'total' => $result['total'],
            'page' => $page,
            'q' => $q,
            'estatus' => $estatus,
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
                'nombre' => trim($_POST['nombre'] ?? ''),
                'apellido' => trim($_POST['apellido'] ?? ''),
                'telefono' => trim($_POST['telefono'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'edad' => (int)($_POST['edad'] ?? 0) ?: null,
                'sexo' => $_POST['sexo'] ?? null,
                'direccion' => trim($_POST['direccion'] ?? ''),
                'estatus' => $_POST['estatus'] ?? 'visitante',
                'notas' => trim($_POST['notas'] ?? ''),
            ];
            if ($data['nombre'] === '' || $data['apellido'] === '') {
                $error = 'Nombre y apellido son obligatorios';
            } else {
                $model = new Asistente($this->config);
                $id = $model->create($data);
                $msg = 'Asistente creado con ID ' . $id;
            }
        }
        $this->view('asistentes/create.php', compact('msg', 'error'));
    }

    public function edit(int $id): void
    {
        Auth::authorize(['admin','editor']);
        $model = new Asistente($this->config);
        $asistente = $model->find($id);
        if (!$asistente) { http_response_code(404); exit('No encontrado'); }
        $msg = null; $error = null;
        if ($this->isPost()) {
            $this->csrfVerify();
            $data = [
                'nombre' => trim($_POST['nombre'] ?? ''),
                'apellido' => trim($_POST['apellido'] ?? ''),
                'telefono' => trim($_POST['telefono'] ?? ''),
                'email' => trim($_POST['email'] ?? ''),
                'edad' => (int)($_POST['edad'] ?? 0) ?: null,
                'sexo' => $_POST['sexo'] ?? null,
                'direccion' => trim($_POST['direccion'] ?? ''),
                'estatus' => $_POST['estatus'] ?? 'visitante',
                'notas' => trim($_POST['notas'] ?? ''),
            ];
            if ($data['nombre'] === '' || $data['apellido'] === '') {
                $error = 'Nombre y apellido son obligatorios';
            } else {
                $model->updateById($id, $data);
                $msg = 'Asistente actualizado';
                $asistente = $model->find($id);
            }
        }
        $this->view('asistentes/edit.php', compact('asistente', 'msg', 'error'));
    }
}

