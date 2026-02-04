<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AgendaModel;
use CodeIgniter\HTTP\ResponseInterface;

class Agenda extends BaseController
{
    public function index()
    {
        $model = new AgendaModel();
        $data = [
            'title' => 'Agenda',
            'agenda' => $model->findAgenda()
        ];
        return view('admin/agenda_index', $data);
    }
    public function insert()
    {
        // Validate CSRF token
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('danger', 'Invalid security token!');
        }

        $data = $this->request->getPost();

        // Sanitize input data
        if (isset($data['agenda_judul'])) {
            $data['agenda_judul'] = strip_tags(trim($data['agenda_judul']));
        }
        if (isset($data['agenda_deskripsi'])) {
            $data['agenda_deskripsi'] = strip_tags(trim($data['agenda_deskripsi']));
        }
        if (isset($data['agenda_waktu'])) {
            $data['agenda_waktu'] = strip_tags(trim($data['agenda_waktu']));
        }
        if (isset($data['agenda_tanggal'])) {
            $data['agenda_tanggal'] = strip_tags(trim($data['agenda_tanggal']));
        }

        $model = new AgendaModel();
        if (!$model->insert($data)) {
            return redirect()->back()
                ->with('errors', $model->errors())
                ->with('danger', 'Data agenda gagal ditambahkan!')
                ->withInput();
        }
        return redirect()->to('admin/agenda')
            ->with('success', 'Data agenda berhasil ditambahkan!');
    }

    public function update()
    {
        // Validate CSRF token
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('danger', 'Invalid security token!');
        }

        $data = $this->request->getPost();
        $agenda_id = (int) $this->request->getPost('agenda_id');

        // Validate agenda_id
        if (!$agenda_id || $agenda_id <= 0) {
            return redirect()->back()->with('danger', 'Invalid agenda ID!');
        }

        // Sanitize input data
        if (isset($data['agenda_judul'])) {
            $data['agenda_judul'] = strip_tags(trim($data['agenda_judul']));
        }
        if (isset($data['agenda_deskripsi'])) {
            $data['agenda_deskripsi'] = strip_tags(trim($data['agenda_deskripsi']));
        }
        if (isset($data['agenda_waktu'])) {
            $data['agenda_waktu'] = strip_tags(trim($data['agenda_waktu']));
        }
        if (isset($data['agenda_tanggal'])) {
            $data['agenda_tanggal'] = strip_tags(trim($data['agenda_tanggal']));
        }

        $model = new AgendaModel();

        // Check if record exists
        $agenda = $model->find($agenda_id);
        if (!$agenda) {
            return redirect()->back()->with('danger', 'Agenda tidak ditemukan!');
        }

        if (!$model->update($agenda_id, $data)) {
            return redirect()->back()
                ->with('errors', $model->errors())
                ->with('danger', 'Data agenda gagal diubah!')
                ->withInput();
        }
        return redirect()->to('admin/agenda')
            ->with('success', 'Data agenda berhasil diubah!');
    }

    function delete()
    {
        // Validate CSRF token
        if (!$this->validate(['csrf_test_name' => 'required'])) {
            return redirect()->back()->with('danger', 'Invalid security token!');
        }

        $agenda_id = (int) $this->request->getPost('agenda_id');

        // Validate agenda_id
        if (!$agenda_id || $agenda_id <= 0) {
            return redirect()->back()->with('danger', 'Invalid agenda ID!');
        }

        $model = new AgendaModel();

        // Check if record exists before deleting
        $agenda = $model->find($agenda_id);
        if (!$agenda) {
            return redirect()->back()->with('danger', 'Agenda tidak ditemukan!');
        }

        $deleted = $model->delete($agenda_id);

        if ($deleted) {
            return redirect()->back()->with('success', 'Data agenda dihapus!');
        } else {
            return redirect()->back()->with('danger', 'Gagal menghapus data agenda!');
        }
    }
}
