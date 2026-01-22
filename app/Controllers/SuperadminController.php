<?php

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;

class SuperadminController extends BaseController
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
            'hal' => '1',
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
            } else {
                $students = $this->ipadModel->getStudentStatusClass($classId, $statusId);
            }

            return $this->response->setJSON($students);
        }

        // Jika bukan AJAX, kirim error atau redirect
        return $this->response->setStatusCode(403, 'Forbidden');
    }

    public function role($params = "", $id = ""): string|RedirectResponse
    {
        if ($params == 'add') {
            $postData = $this->request->getPost();
            $this->roleModel->save($postData);
            session()->setFlashdata("success", "Data Role has been successfully added!");
            return redirect()->to('superadmin/role');
        } elseif ($params == 'update') {
            $postData = $this->request->getPost();
            $this->roleModel->update($postData['id'], $postData);
            session()->setFlashdata("success", "Data Role has been successfully updated!");
            return redirect()->to('superadmin/role');
        } elseif ($params == 'delete') {
            $this->roleModel->delete($id);
            session()->setFlashdata("success", "Data Role has been successfully deleted!");
            return redirect()->to('superadmin/role');
        } else {
            $rolesData = $this->roleModel->findAll();
            return $this->_renderView('superadmin/role', [
                'title' => 'User Role',
                'hal' => '2',
                'roles' => $rolesData,
            ]);
        }
    }

    public function navigation($role = "", $params = "", $id = ""): string|RedirectResponse
    {
        if ($params == 'add') {
            $postData = $this->request->getPost();
            $this->navigationModel->save($postData);
            session()->setFlashdata("success", "User Navitagion has been successfully added!");
            return redirect()->to('superadmin/navigation/' . $role);
        } elseif ($params == 'delete') {
            $this->navigationModel->delete($id);
            session()->setFlashdata("success", "User Navigation has been successfully deleted!");
            return redirect()->to('superadmin/navigation/' . $role);
        } else {
            $roleData = $this->roleModel->find($role);
            if (!$roleData) {
                session()->setFlashdata("error", "Role tidak ditemukan.");
                return redirect()->to('superadmin/role');
            }
            $navigationData = $this->navigationModel->getNavigationWithDetails($role);
            $availableMenus = $this->menuModel->getUnassignedMenusForRole($role);
            return $this->_renderView('superadmin/navigation', [
                'title' => 'User Navigation',
                'hal' => '2',
                'navigation' => $navigationData,
                'role' => $roleData,
                'availableMenus' => $availableMenus,
            ]);
        }
    }

    public function menu($params = "", $id = ""): string|RedirectResponse
    {
        if ($params == 'add') {
            $postData = $this->request->getPost();
            $this->menuModel->save($postData);
            session()->setFlashdata("success", "Data menu has been successfully added!");
            return redirect()->to('superadmin/menu');
        } elseif ($params == 'update') {
            $postData = $this->request->getPost();
            $this->menuModel->update($postData['id'], $postData);
            session()->setFlashdata("success", "Data menu has been successfully updated!");
            return redirect()->to('superadmin/menu');
        } elseif ($params == 'delete') {
            $this->menuModel->delete($id);
            session()->setFlashdata("success", "Data menu has been successfully deleted!");
            return redirect()->to('superadmin/menu');
        } else {
            $menusData = $this->menuModel->findAll();
            return $this->_renderView('superadmin/menu', [
                'title' => 'Menu',
                'hal' => '3',
                'menus' => $menusData,
            ]);
        }
    }



    public function submenu($menu = "", $params = "", $id = ""): string|RedirectResponse
    {
        if ($params == 'add') {
            $postData = $this->request->getPost();

            $lastSubMenu = $this->menusubModel
                ->where('id_menu', $menu)
                ->orderBy('no', 'DESC')
                ->countAllResults();

            $postData['no'] = $lastSubMenu + 1;

            $uniqueString = bin2hex(random_bytes(16));
            $postData['id_unique'] = $uniqueString;

            $this->menusubModel->save($postData);
            session()->setFlashdata("success", "Data menu has been successfully added!");
            return redirect()->to('superadmin/submenu/' . $menu);
        } elseif ($params == 'update') {
            $postData = $this->request->getPost();
            $this->menusubModel->update($postData['id'], $postData);
            session()->setFlashdata("success", "Data menu has been successfully updated!");
            return redirect()->to('superadmin/submenu/' . $menu);
        } elseif ($params == 'delete') {
            $this->menusubModel->delete($id);
            session()->setFlashdata("success", "Data menu has been successfully deleted!");
            return redirect()->to('superadmin/submenu/' . $menu);
        } else {
            $subMenus = $this->menusubModel->where('id_menu', $menu)->findAll();
            $data_menu = $this->menuModel->where('id', $menu)->first();
            return $this->_renderView('superadmin/submenu', [
                'title' => 'Sub Menu',
                'hal' => '3',
                'menus' => $subMenus,
                'id_menu' => $menu,
                'data_menu' => $data_menu
            ]);
        }
    }


    public function akun($params = "", $id = "")
    {
        if ($params == 'add') {
            $postData = $this->request->getPost();


            $uniqueString = bin2hex(random_bytes(16));
            $dataUser = [
                'id_unique' => $uniqueString,
                'username' => $postData['username'],
                'password' => password_hash($postData['password'], PASSWORD_DEFAULT),
                'is_active' => '1',
                'id_role' => $postData['id_role']
            ];
            $this->usersModel->save($dataUser);


            $data_user = $this->usersModel->where('id_unique', $uniqueString)->first();
            $data_role = $this->roleModel->where('id', $postData['id_role'])->first();
            $dataEmployee = [
                'name' => $postData['name'],
                'position' => $data_role['name'],
                'id_user' => $data_user['id']
            ];
            $this->employeeModel->save($dataEmployee);
            echo $data_user['id'];

            session()->setFlashdata("success", "Data Employee has been successfully added!");
            return redirect()->to('superadmin/akun');
        } elseif ($params == 'update') {
            $postData = $this->request->getPost();

            // 1. Update employee name
            $employeeId = $postData['employee_id'];
            $dataEmployee = [
                'name' => $postData['name'],
            ];
            $this->employeeModel->update($employeeId, $dataEmployee);

            // 2. Update user data (username, role, and optional password)
            $userId = $postData['user_id'];
            $dataUser = [
                'username' => $postData['username'],
                'id_role'  => $postData['id_role'],
            ];

            // 2a. Check if a new password was provided
            if (!empty($postData['password'])) {
                $dataUser['password'] = password_hash($postData['password'], PASSWORD_DEFAULT);
            }
            $this->usersModel->update($userId, $dataUser);

            // 3. Update position in employee table based on new role
            $newRole = $this->roleModel->find($postData['id_role']);
            if ($newRole) {
                $this->employeeModel->update($employeeId, ['position' => $newRole['name']]);
            }

            session()->setFlashdata("success", "Data Akun telah berhasil diperbarui!");
            return redirect()->to('superadmin/akun');
        } elseif ($params == 'delete') {
            $data_employee = $this->employeeModel->where('id', $id)->first();
            $this->usersModel->delete($data_employee['id_user']);
            session()->setFlashdata("success", "Data Akun has been successfully deleted!");
            return redirect()->to('superadmin/akun');
        } else {
            $userData = $this->employeeModel->getAllUserEmployee();
            $rolesData = $this->roleModel->findAll();
            return $this->_renderView('superadmin/account', [
                'title' => 'Akun',
                'hal' => '11',
                'users' => $userData,
                'roles' => $rolesData,
            ]);
        }
    }
}
