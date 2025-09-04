<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PageModel;
use CodeIgniter\HTTP\ResponseInterface;
use DOMDocument;

class Page extends BaseController
{
    public function index()
    {
        $model = new PageModel();
        $data = [
            'title' => 'Page',
            'page' => $model->orderBy('page_id', 'desc')->findAll()
        ];
        return view('admin/page_index', $data);
    }

    function edit($page_id)
    {
        $model = new PageModel();

        $data = [
            'title' => 'Edit Page',
            'page' => $model->find($page_id),
        ];
        return view('admin/page_form', $data);
    }
    function update()
    {

        // Proses Data Sekolah
        $berita_id = $this->request->getPost('page_id');
        $datapage = $this->request->getPost();
        // dd($this->request->getFile('file'));

        //Insert data to Sekolah
        //find images
        $model = new PageModel();
        $model->update($berita_id, $datapage);

        //done
        return redirect()->to('admin/page')
            ->with('message', "Toastify({'text':'berita diupdate!'}).showToast()");
    }
}
