<?php

namespace App\Controllers;

class AjaxController extends BaseController
{
    // -------------------------------- Ajax Edit Role -------------------------------- //
    public function edit_role($id = "")
    {
        $role = $this->roleModel->where('id', $id)->first();
        echo '
        <input id="text" type="hidden" class="form-control " name="id" required style="padding-left: 10px;" value="' . $id . '">

        <div class="row">
            <div class="col-md-6 mb-3 mb-3">
                <div class="form-group form-group-default">
                    <label>Nama Role</label>
                    <input id="text" type="text" class="form-control" placeholder="Nama Role" name="name" required style="padding-left: 10px;" value="' . $role['name'] . '">
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="form-group form-group-default">
                    <label>URL</label>
                    <input id="addPosition" type="text" class="form-control" placeholder="url" name="url" required style="padding-left: 10px;" value="' . $role['url'] . '">
                </div>
            </div>
        </div>';
    }

    // -------------------------------- Ajax Edit menu -------------------------------- //
    public function edit_menu($id = "")
    {
        $menu = $this->menuModel->where('id', $id)->first();
        echo '
        <input id="text" type="hidden" class="form-control " name="id" required style="padding-left: 10px;" value="' . $id . '">

        <div class="row">
            <div class="col-md-12 mb-3 mb-3">
                <div class="form-group form-group-default">
                    <label>Nama menu</label>
                    <input id="text" type="text" class="form-control " placeholder="Nama menu" name="name" required style="padding-left: 10px;" value="' . $menu['name'] . '">
                </div>
            </div>
        </div>';
    }


    // -------------------------------- Ajax Edit submenu -------------------------------- //
    public function edit_submenu($id = "")
    {
        $menusub = $this->menusubModel->where('id', $id)->first();
        echo '
        <input id="text" type="hidden" class="form-control " name="id" required style="padding-left: 10px;" value="' . $id . '">

        <div class="row">
            <div class="col-md-6 mb-3 mb-3">
                <div class="form-group form-group-default">
                    <label>Nama Sub Menu</label>
                    <input id="text" type="text" class="form-control " placeholder="Nama Menu Sub" name="name" required style="padding-left: 10px;" value="' . $menusub['name'] . '">
                </div>
            </div>
            <div class="col-md-6 mb-3 mb-3">
                <div class="form-group form-group-default">
                    <label>Nama Sub Menu</label>
                    <input id="text" type="text" class="form-control " placeholder="Nama Menu Sub" name="url" required style="padding-left: 10px;" value="' . $menusub['url'] . '">
                </div>
            </div>
            <div class="col-md-12 mb-3 mb-3">
                <div class="form-group form-group-default">
                    <label>Nama Sub Menu</label>
                    <input id="text" type="text" class="form-control " placeholder="Nama Menu Sub" name="icon" required style="padding-left: 10px;" value="' . $menusub['icon'] . '">
                </div>
            </div>
            
        </div>';
    }


    // -------------------------------- Ajax Edit Siswa -------------------------------- //
    public function edit_siswa($id = "")
    {
        $student = $this->studentModel->where('id', $id)->first();
        $classData = $this->classModel->findAll();
        $kels = '';
        foreach ($classData as $row) :
            $kels = $kels.'<option value="'.$row['id'].'" '.($student['id_class'] == $row['id'] ? 'selected' : '').'>'.$row['id'].'</option>';
        endforeach; 
        echo '
        <input id="text" type="hidden" class="form-control " name="id" required style="padding-left: 10px;" value="' . $id . '">

                            <div class="row">
                                <div class="col-md-6 mb-3 mb-3">
                                        <div class="form-group form-group-default">
                                        <label>NIS</label>
                                        <input id="text" type="number" class="form-control " placeholder="Masukkan Nis Siswa" name="nis" value="' . $student['nis'] . '"  required style="padding-left: 10px;">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group form-group-default">
                                        <label>Nama Siswa</label>
                                        <input id="addPosition" type="text" class="form-control " placeholder="Masukkan Siswa Siswa" name="name" value="' . $student['name'] . '"  required style="padding-left: 10px;">
                                    </div>
                                </div>

                                <div class="col-md-6 mb-3 mb-3">
                                    <div class="form-group form-group-default">
                                        <label>Jenis Kelamin</label>
                                        <select class="form-control "  name="gender" required style="padding-left: 10px;">
                                            <option value="Laki-Laki" '.($student['gender'] == 'Laki-Laki' ? 'selected' : '').'>Laki-Laki</option>
                                            <option value="Perempuan" '.($student['gender'] == 'Perempuan' ? 'selected' : '').'>Perempuan</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group form-group-default">
                                        <label>Kelas</label>

                                        <select class="form-control" name="id_class" required style="padding-left: 10px;">
                                            '.$kels.'
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3 mb-3">
                                    <div class="form-group form-group-default">
                                        <label>Nama Orang Tua</label>
                                        <input id="text" type="text" class="form-control " placeholder="Nama Orang Tua Siswa" name="mother_name" value="' . $student['mother_name'] . '" required style="padding-left: 10px;">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group form-group-default">
                                        <label>No Whatsapp Orang Tua</label>
                                        <input id="addPosition" type="number" class="form-control " placeholder="No Whatsapp Orang Tua Siswa" name="whatsapp" value="' . $student['whatsapp'] . '" required style="padding-left: 10px;">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3 mb-3">
                                    <div class="form-group form-group-default">
                                        <label>Nama Wali Asrama</label>
                                        <input id="text" type="text" class="form-control " placeholder="Nama Wali Asrama Siswa" name="dormitory_name" value="' . $student['dormitory_name'] . '" required style="padding-left: 10px;">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group form-group-default">
                                        <label>No Whatsapp Wali Asrama</label>
                                        <input id="addPosition" type="number" class="form-control " placeholder="No Whatsapp Wali Asrama Siswa" name="dormitory_wa" value="' . $student['dormitory_wa'] . '" required style="padding-left: 10px;">
                                    </div>
                                </div>
            
        </div>';
    }





    // -------------------------------- Ajax Edit Ipad -------------------------------- //
    public function edit_ipad($id = "")
    {
        $ipad = $this->ipadModel->where('id', $id)->first();
        echo '
        <input id="text" type="hidden" class="form-control " name="id" required style="padding-left: 10px;" value="' . $id . '">

        <div class="row">
            <div class="col-md-6 mb-3 mb-3">
                <div class="form-group form-group-default">
                    <label>Masukkan Model Ipad</label>
                    <input id="text" type="text" class="form-control " placeholder="Nama Menu Sub" name="model" required style="padding-left: 10px;" value="' . $ipad['model'] . '">
                </div>
            </div>
            <div class="col-md-6 mb-3 mb-3">
                <div class="form-group form-group-default">
                    <label>Warna Ipad</label>
                    <input id="text" type="text" class="form-control " placeholder="Masukkan Warna Ipad" name="color" required style="padding-left: 10px;" value="' . $ipad['color'] . '">
                </div>
            </div>
            <div class="col-md-6 mb-3 mb-3">
                <div class="form-group form-group-default">
                    <label>Kondisi Ipad</label>
                    <select class="form-control "  name="grade" value="' . $ipad['grade'] . '" required style="padding-left: 10px;">
                        <option value="Bagus">Bagus</option>
                        <option value="Sedikit Rusak">Sedikit Rusak</option>
                        <option value="Rusak">Rusak</option>
                        <option value="Mati Total">Mati Total</option>
                    </select>
                </div>
            </div>
            <div class="col-md-6 mb-3 mb-3">
                <div class="form-group form-group-default">
                    <label>Status Ipad</label>
                    <select class="form-control "  name="status" value="' . $ipad['status'] . '" required style="padding-left: 10px;">
                        <option value="Disimpan">Disimpan</option>
                        <option value="Pembelajaran">Pembelajaran</option>
                        <option value="Pinjam">Pinjam</option>
                    </select>
                </div>
            </div>
            <div class="col-md-12 mb-3 mb-3">
                <div class="form-group form-group-default">
                    <label>Catatan</label>
                    <input id="text" type="text" class="form-control " placeholder="Masukkan catatan" name="note" required style="padding-left: 10px;" value="' . $ipad['note'] . '">
                </div>
            </div>
            
        </div>';
    }


    // -------------------------------- Ajax Edit Kelas -------------------------------- //
    public function edit_kelas($id = "")
    {
        $class = $this->classModel->where('id', $id)->first();
        echo '
        <input id="text" type="hidden" class="form-control " name="id" required style="padding-left: 10px;" value="' . $id . '">

        <div class="row">
            <div class="col-md-12 mb-3 mb-3">
                <div class="form-group form-group-default">
                    <label>Nama Kelas</label>
                    <input id="text" type="text" class="form-control" placeholder="Nama Kelas" name="class_name" required style="padding-left: 10px;" value="' . $class['class_name'] . '">
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="form-group form-group-default">
                    <label>Tingkatan Kelas</label>
                    <select id="addPosition" class="form-control" name="grade" required style="padding-left: 10px;">
                        <option value="Sepuluh (X)" '.($class['grade'] == 'Sepuluh (X)' ? 'selected' : '').'>Sepuluh (X)</option>
                        <option value="Sebelas (XI)" '.($class['grade'] == 'Sebelas (XI)' ? 'selected' : '').'>Sebelas (XI)</option>
                        <option value="Dua Belas (XII)" '.($class['grade'] == 'Dua Belas (XII)' ? 'selected' : '').'>Dua Belas (XII)</option>
                </select>
                </div>
            </div>
            <div class="col-md-6 mb-3">
                <div class="form-group form-group-default">
                    <label>Jurusan Kelas</label>
                    <input id="addPosition" type="text" class="form-control" placeholder="Jurusan Kelas" name="major" required style="padding-left: 10px;" value="' . $class['major'] . '">
                </div>
            </div>
        </div>';
    }


    public function edit_akun($id = "")
{
    // This $id is the id from the user_employee table
    $employee = $this->employeeModel->find($id);
    if (!$employee) {
        return 'Employee not found';
    }

    $user = $this->usersModel->find($employee['id_user']);
    if (!$user) {
        return 'User not found';
    }

    $roles = $this->roleModel->findAll();
    $role_options = '';
    foreach ($roles as $role) {
        $selected = ($user['id_role'] == $role['id']) ? 'selected' : '';
        $role_options .= '<option value="' . $role['id'] . '" ' . $selected . '>' . esc($role['name']) . '</option>';
    }

    // Return the HTML form fields for the modal
    echo '
    <input type="hidden" name="employee_id" value="' . esc($employee['id']) . '">
    <input type="hidden" name="user_id" value="' . esc($user['id']) . '">

    <div class="row">
        <div class="col-md-6 mb-3">
            <div class="form-group form-group-default">
                <label>Nama Akun</label>
                <input type="text" class="form-control" name="name" required value="' . esc($employee['name']) . '" style="padding-left: 10px;">
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="form-group form-group-default">
                <label>Pilih Role</label>
                <select class="form-control" name="id_role" required style="padding-left: 10px;">
                    ' . $role_options . '
                </select>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="form-group form-group-default">
                <label>Username Akun</label>
                <input type="text" class="form-control" name="username" required value="' . esc($user['username']) . '" style="padding-left: 10px;">
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="form-group form-group-default">
                <label>Password (Opsional)</label>
                <input type="password" class="form-control" placeholder="Isi untuk ganti password" name="password" style="padding-left: 10px;">
            </div>
        </div>
    </div>';
}
}
