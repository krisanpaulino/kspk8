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
        $data = $this->request->getPost();
        $model = new AgendaModel();
        if (!$model->insert($data)) {
            return redirect()->back()
                ->with('danger', 'Data agenda gagal ditambahkan!')
                ->withInput();
        }
        return redirect()->to('admin/agenda')
            ->with('success', 'Data agenda berhasil ditambahkan!');
    }
    public function update()
    {
        $data = $this->request->getPost();
        $agenda_id = $this->request->getPost('agenda_id');
        $model = new AgendaModel();
        $model->where('agenda_id', $agenda_id);
        $model->set($data);
        if (!$model->update($data)) {
            return redirect()->back()
                ->with('danger', 'Data agenda gagal diubah!')
                ->withInput();
        }
        return redirect()->to('admin/agenda')
            ->with('success', 'Data agenda berhasil diubah!');
    }
    function delete()
    {
        $agenda_id = $this->request->getPost('agenda_id');
        $model = new AgendaModel();
        $model->where('agenda_id', $agenda_id);
        $model->delete();
        return redirect()->back()->with('success', 'Data kerjasama dihapus!');
    }
}
