<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;

class AdminController extends BaseController
{

    private function _renderView(string $viewPath, array $pageData): string
    {
        $authDataForView = $this->authData; // Assign ke variabel lokal dulu
        $data = array_merge($authDataForView, $pageData);

        return view($viewPath, $data);
    }


    public function index(): string
    {
        return $this->_renderView('dashboard/index', [
            'title' => 'Dashboard',
            'hal' => '  4',
            'count_all_ipad' => $this->ipadModel->countAllResults(),
            'count_rak_ipad' => $this->ipadModel->where('status', 'Disimpan')->countAllResults(),
            'count_class_ipad' => $this->ipadModel->where('status', 'Pembelajaran')->countAllResults(),
            'count_rent_ipad' => $this->ipadModel->where('status', 'Pinjam')->countAllResults(),
            'all_ipad' => $this->ipadModel->getAllIpad(),
            'rak_ipad' => $this->ipadModel->getStoreIpad(),
            'class_ipad' => $this->ipadModel->getClassIpad(),
            'rent_ipad' => $this->ipadModel->getRentIpad(),
            'classes' => $this->classModel->orderBy('class_name', 'ASC')->findAll(),
        ]);
    }

    public function getStudentsByClass()
    {
        // Validasi bahwa ini adalah request AJAX
        if ($this->request->isAJAX()) {
            $classId = $this->request->getVar('class_id');
            $statusId = $this->request->getVar('status_id');
            if ($statusId == 'All') {
                $students = $this->ipadModel->getStudentClass($classId);
            }else{
                $students = $this->ipadModel->getStudentStatusClass($classId, $statusId);
            }

            return $this->response->setJSON($students);
        }

        // Jika bukan AJAX, kirim error atau redirect
        return $this->response->setStatusCode(403, 'Forbidden');
    }
}
