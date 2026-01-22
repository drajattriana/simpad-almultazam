<?php

namespace App\Controllers;

use App\Models\ScanModel;
use App\Models\StudentModel;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\LabelAlignment;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
// -----------------------------------------

use CodeIgniter\HTTP\RedirectResponse;

class StudentController extends BaseController
{
    private function _renderView(string $viewPath, array $pageData): string
    {
        $authDataForView = $this->authData;
        $data = array_merge($authDataForView, $pageData);
        return view($viewPath, $data);
    }

    public function student($params = "", $id = ""): string|RedirectResponse
    {
        if ($params == 'add') {
            $postData = $this->request->getPost();
            $wa = $postData['whatsapp'];
            $wa2 = $postData['dormitory_wa'];

            // Bersihkan spasi & simbol
            $wa = preg_replace('/[^0-9]/', '', $wa);
            $wa2 = preg_replace('/[^0-9]/', '', $wa2);

            // Jika diawali 0 → ganti jadi 62
            if (substr($wa, 0, 1) == '0') {
                $wa = '62' . substr($wa, 1);
            }
            if (substr($wa2, 0, 1) == '0') {
                $wa2 = '62' . substr($wa2, 1);
            }

            // Jika diawali 8 → tambahkan 62
            else if (substr($wa, 0, 1) == '8') {
                $wa = '62' . $wa;
            } else if (substr($wa2, 0, 1) == '8') {
                $wa2 = '62' . $wa2;
            }

            // Masukkan kembali ke postData
            $postData['whatsapp'] = $wa;
            $postData['dormitory_wa'] = $wa2;

            if (empty($postData['nis'])) {
                session()->setFlashdata("error", "NIS tidak boleh kosong!");
                return redirect()->back()->withInput();
            }

            $qrData = $postData['nis'];
            $qrFileName = $qrData . '.png';
            $qrPath = FCPATH . 'upload/qr/';

            if (!is_dir($qrPath)) {
                mkdir($qrPath, 0777, true);
            }

            $qrCode = new QrCode($qrData);
            $qrCode->setSize(300);
            $qrCode->setMargin(10);
            // $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::HIGH);
            $qrCode->setEncoding('UTF-8');
            // $qrCode->setLabel($postData['name']);
            // $qrCode->setLabelFontSize(16);
            // $qrCode->setLabelAlignment(LabelAlignment::CENTER);

            $qrCode->writeFile($qrPath . $qrFileName);

            // === Overlay QR into template box (relative placement) ===
            $templatePath = FCPATH . 'upload/qr-template.png';
            $qrFullPath   = $qrPath . $qrFileName;

            if (is_file($templatePath)) {
                $templateImg = imagecreatefrompng($templatePath);
                $qrImg       = imagecreatefrompng($qrFullPath);

                // Preserve alpha channel
                imagesavealpha($templateImg, true);
                imagealphablending($templateImg, true);
                imagesavealpha($qrImg, true);
                imagealphablending($qrImg, true);

                $tplW = imagesx($templateImg);
                $tplH = imagesy($templateImg);

                $qrW  = imagesx($qrImg);
                $qrH  = imagesy($qrImg);

                // Target square area inside template (tuned for your provided template)
                $marginX = (int)round($tplW * 0.075);   // ~7.5% left/right padding
                $boxTop  = (int)round($tplH * 0.155);   // ~17.5% from top (below header)
                $boxSize = $tplW - ($marginX * 2);      // square based on width

                // Inner padding inside the black frame
                $innerPad = (int)round($boxSize * 0.04); // ~4% padding
                $maxW = $boxSize - ($innerPad * 2);
                $maxH = $boxSize - ($innerPad * 2);

                // Scale QR to fit the target square
                $scale = min($maxW / $qrW, $maxH / $qrH);
                $newW  = (int)floor($qrW * $scale);
                $newH  = (int)floor($qrH * $scale);

                // Center QR inside the target square
                $dstX = (int)($marginX + ($boxSize - $newW) / 2);
                $dstY = (int)($boxTop  + ($boxSize - $newH) / 2);

                // Draw QR onto template
                imagecopyresampled(
                    $templateImg,
                    $qrImg,
                    $dstX,
                    $dstY,
                    0,
                    0,
                    $newW,
                    $newH,
                    $qrW,
                    $qrH
                );

                // --- Draw test text in bottom box ---

                $data_class = $this->classModel->where('id', $postData['id_class'])->first();

                // --- Build display name: keep first word, rest become initials if too long ---
                $fullName = trim((string) $postData['name']);
                $parts = preg_split('/\s+/', $fullName, -1, PREG_SPLIT_NO_EMPTY);

                $displayName = $fullName;
                if (count($parts) >= 2) {
                    $first = $parts[0];
                    $initials = [];
                    for ($i = 1; $i < count($parts); $i++) {
                        $ch = mb_substr($parts[$i], 0, 1, 'UTF-8');
                        if ($ch !== '') $initials[] = mb_strtoupper($ch, 'UTF-8');
                    }
                    $shortName = $first . ' ' . implode(' ', $initials);

                    // If name is long, use the short version
                    if (mb_strlen($fullName, 'UTF-8') > 18) { // adjust threshold if needed
                        $displayName = $shortName;
                    }
                }

                $text = $displayName . " - " . $data_class['class_name'];
                $black = imagecolorallocate($templateImg, 0, 0, 0);


                // Bottom text area (relative to template height)
                $textBoxTop = (int) round($tplH * 0.85);
                $textBoxH   = (int) round($tplH * 0.10);

                // --- Use TTF font for bigger text ---
                $fontPath = FCPATH . 'fonts/DejaVuSans-Bold.ttf';
                $fontSize = 120; // change this to increase/decrease text size

                $bbox  = imagettfbbox($fontSize, 0, $fontPath, $text);
                $textW = abs($bbox[2] - $bbox[0]);
                $textH = abs($bbox[7] - $bbox[1]);

                // Center text inside the bottom box (imagettftext uses baseline)
                $x = (int) round(($tplW - $textW) / 2);
                $y = (int) round($textBoxTop + (($textBoxH + $textH) / 2) - 8);

                imagettftext($templateImg, $fontSize, 0, $x, $y, $black, $fontPath, $text);

                // Save final image (overwrite)
                imagepng($templateImg, $qrFullPath);


                // Free memory
                imagedestroy($templateImg);
                imagedestroy($qrImg);
            }
            // ====================================================


            // ====================================================

            $uploadSiswa = $postData;
            unset($uploadSiswa['model'], $uploadSiswa['color'], $uploadSiswa['grade'], $uploadSiswa['note'], $uploadSiswa['status']);
            $this->studentModel->save($uploadSiswa);

            $data_student = $this->studentModel->where('nis', $postData['nis'])->first();
            $uploadIpad = [
                'model' => $postData['model'],
                'color' => $postData['color'],
                'grade' => $postData['grade'],
                'note' => $postData['note'],
                'status' => $postData['status'],
                'nis' => $postData['nis'],
                'id_student' => $data_student['id'],
            ];
            $this->ipadModel->save($uploadIpad);

            session()->setFlashdata("success", "Data Student has been successfully added!");
            return redirect()->to('siswa');
        } elseif ($params == 'update') {
            $postData = $this->request->getPost();
            $this->studentModel->update($postData['id'], $postData);
            session()->setFlashdata("success", "Data Student has been successfully updated!");
            return redirect()->to('siswa');
        } elseif ($params == 'delete') {
            $student = $this->studentModel->find($id);

            if ($student) {
                $qrFileName = $student['nis'] . '.png';
                $qrFilePath = FCPATH . 'upload/qr/' . $qrFileName;

                if (file_exists($qrFilePath)) {
                    unlink($qrFilePath);
                }
                $this->studentModel->delete($id);

                session()->setFlashdata("success", "Data Student has been successfully deleted!");
            } else {
                session()->setFlashdata("error", "Data Student not found!");
            }

            return redirect()->to('siswa');
        } else {
            $studentData = $this->studentModel->getAllStudent();
            $classData = $this->classModel->findAll();
            return $this->_renderView('student/student', [
                'title' => 'Siswa',
                'hal' => '5',
                'student' => $studentData,
                'classData' => $classData
            ]);
        }
    }

    public function import(): RedirectResponse
    {
        $file = $this->request->getFile('excel_file');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            $spreadsheet = $reader->load($file->getTempName());
            $sheet = $spreadsheet->getActiveSheet()->toArray();

            // Skip header row (index 0)
            $dataToImport = array_slice($sheet, 1);

            foreach ($dataToImport as $row) {
                // Map columns to variables, ensure they are not null
                $postData = [
                    'nis'            => $row[0] ?? null,
                    'name'           => $row[1] ?? null,
                    'gender'         => $row[2] ?? null,
                    // id_class will be determined below
                    'id_class'       => null,
                    'mother_name'    => $row[4] ?? '-',
                    'whatsapp'       => $row[5] ?? '0',
                    'dormitory_name' => $row[6] ?? '-',
                    'dormitory_wa'   => $row[7] ?? '0',
                    'model'          => $row[8] ?? '-',
                    'color'          => $row[9] ?? '-',
                    'grade'          => $row[10] ?? 'Bagus',
                    'status'         => $row[11] ?? 'Disimpan',
                    'note'           => $row[12] ?? '-',
                ];

                // --- Start: Logic to find or create class by name ---
                $classNameFromExcel = trim($row[3] ?? ''); // Get class name from Excel (Column D)

                if (empty($classNameFromExcel)) {
                    continue; // Skip row if class name is not provided
                }

                // Find class by name, case-insensitive
                $classData = $this->classModel->where('LOWER(class_name)', strtolower($classNameFromExcel))->first();

                $classId = null;
                if ($classData) {
                    // If class exists, get its ID
                    $classId = $classData['id'];
                } else {
                    // If class does not exist, create a new one
                    $newClassData = ['class_name' => $classNameFromExcel];
                    // The insert() method returns the new primary key (ID)
                    $classId = $this->classModel->insert($newClassData);
                }

                // Assign the found or new class ID to postData
                $postData['id_class'] = $classId;
                // --- End: Logic to find or create class by name ---


                if (empty($postData['nis']) || empty($postData['name']) || empty($postData['id_class'])) {
                    continue; // Skip row if essential data is missing, including class
                }

                // --- Start: Logic copied from add() method ---
                $wa = $postData['whatsapp'];
                $wa2 = $postData['dormitory_wa'];

                $wa = preg_replace('/[^0-9]/', '', (string)$wa);
                $wa2 = preg_replace('/[^0-9]/', '', (string)$wa2);

                if (substr($wa, 0, 1) == '0') $wa = '62' . substr($wa, 1);
                else if (substr($wa, 0, 1) == '8') $wa = '62' . $wa;

                if (substr($wa2, 0, 1) == '0') $wa2 = '62' . substr($wa2, 1);
                else if (substr($wa2, 0, 1) == '8') $wa2 = '62' . $wa2;

                $postData['whatsapp'] = $wa;
                $postData['dormitory_wa'] = $wa2;

                $qrData = (string)$postData['nis'];
                $qrFileName = $qrData . '.png';
                $qrPath = FCPATH . 'upload/qr/';

                if (!is_dir($qrPath)) {
                    mkdir($qrPath, 0777, true);
                }

                $qrCode = new QrCode($qrData);

                // Set QR Code properties one by one
                $qrCode->setSize(300);
                $qrCode->setMargin(10);
                $qrCode->setEncoding('UTF-8');
                // $qrCode->setLabel($postData['name']);
                // $qrCode->setLabelFontSize(16);
                // $qrCode->setLabelAlignment(LabelAlignment::CENTER);

                // Write the QR Code to a file

                $qrCode->writeFile($qrPath . $qrFileName);

                // === Overlay QR into template box (relative placement) ===
                $templatePath = FCPATH . 'upload/qr-template.png';
                $qrFullPath   = $qrPath . $qrFileName;

                if (is_file($templatePath)) {
                    $templateImg = imagecreatefrompng($templatePath);
                    $qrImg       = imagecreatefrompng($qrFullPath);

                    // Preserve alpha channel
                    imagesavealpha($templateImg, true);
                    imagealphablending($templateImg, true);
                    imagesavealpha($qrImg, true);
                    imagealphablending($qrImg, true);

                    $tplW = imagesx($templateImg);
                    $tplH = imagesy($templateImg);

                    $qrW  = imagesx($qrImg);
                    $qrH  = imagesy($qrImg);

                    // Target square area inside template (tuned for your provided template)
                    $marginX = (int)round($tplW * 0.075);   // ~7.5% left/right padding
                    $boxTop  = (int)round($tplH * 0.155);   // ~17.5% from top (below header)
                    $boxSize = $tplW - ($marginX * 2);      // square based on width

                    // Inner padding inside the black frame
                    $innerPad = (int)round($boxSize * 0.04); // ~4% padding
                    $maxW = $boxSize - ($innerPad * 2);
                    $maxH = $boxSize - ($innerPad * 2);

                    // Scale QR to fit the target square
                    $scale = min($maxW / $qrW, $maxH / $qrH);
                    $newW  = (int)floor($qrW * $scale);
                    $newH  = (int)floor($qrH * $scale);

                    // Center QR inside the target square
                    $dstX = (int)($marginX + ($boxSize - $newW) / 2);
                    $dstY = (int)($boxTop  + ($boxSize - $newH) / 2);

                    // Draw QR onto template
                    imagecopyresampled(
                        $templateImg,
                        $qrImg,
                        $dstX,
                        $dstY,
                        0,
                        0,
                        $newW,
                        $newH,
                        $qrW,
                        $qrH
                    );

                    // --- Draw test text in bottom box ---

                    $data_class = $this->classModel->where('id', $postData['id_class'])->first();

                    // --- Build display name: keep first word, rest become initials if too long ---
                    $fullName = trim((string) $postData['name']);
                    $parts = preg_split('/\s+/', $fullName, -1, PREG_SPLIT_NO_EMPTY);

                    $displayName = $fullName;
                    if (count($parts) >= 2) {
                        $first = $parts[0];
                        $initials = [];
                        for ($i = 1; $i < count($parts); $i++) {
                            $ch = mb_substr($parts[$i], 0, 1, 'UTF-8');
                            if ($ch !== '') $initials[] = mb_strtoupper($ch, 'UTF-8');
                        }
                        $shortName = $first . ' ' . implode(' ', $initials);

                        // If name is long, use the short version
                        if (mb_strlen($fullName, 'UTF-8') > 18) { // adjust threshold if needed
                            $displayName = $shortName;
                        }
                    }

                    $text = $displayName . " - " . $data_class['class_name'];
                    $black = imagecolorallocate($templateImg, 0, 0, 0);


                    // Bottom text area (relative to template height)
                    $textBoxTop = (int) round($tplH * 0.85);
                    $textBoxH   = (int) round($tplH * 0.10);

                    // --- Use TTF font for bigger text ---
                    $fontPath = FCPATH . 'fonts/DejaVuSans-Bold.ttf';
                    $fontSize = 120; // change this to increase/decrease text size

                    $bbox  = imagettfbbox($fontSize, 0, $fontPath, $text);
                    $textW = abs($bbox[2] - $bbox[0]);
                    $textH = abs($bbox[7] - $bbox[1]);

                    // Center text inside the bottom box (imagettftext uses baseline)
                    $x = (int) round(($tplW - $textW) / 2);
                    $y = (int) round($textBoxTop + (($textBoxH + $textH) / 2) - 8);

                    imagettftext($templateImg, $fontSize, 0, $x, $y, $black, $fontPath, $text);

                    // Save final image (overwrite)
                    imagepng($templateImg, $qrFullPath);


                    // Free memory
                    imagedestroy($templateImg);
                    imagedestroy($qrImg);
                }
                // ====================================================

                $uploadSiswa = [
                    'nis' => $postData['nis'],
                    'name' => $postData['name'],
                    'gender' => $postData['gender'],
                    'id_class' => $postData['id_class'],
                    'mother_name' => $postData['mother_name'],
                    'whatsapp' => $postData['whatsapp'],
                    'dormitory_name' => $postData['dormitory_name'],
                    'dormitory_wa' => $postData['dormitory_wa']
                ];
                $this->studentModel->save($uploadSiswa);

                $data_student = $this->studentModel->where('nis', $postData['nis'])->first();
                if ($data_student) {
                    $uploadIpad = [
                        'model' => $postData['model'],
                        'color' => $postData['color'],
                        'grade' => $postData['grade'],
                        'note' => $postData['note'],
                        'status' => $postData['status'],
                        'nis' => $postData['nis'],
                        'id_student' => $data_student['id'],
                    ];
                    $this->ipadModel->save($uploadIpad);
                }
                // --- End: Logic copied from add() method ---
            }

            session()->setFlashdata("success", "Data siswa berhasil diimpor dari Excel.");
        } else {
            session()->setFlashdata("error", "Gagal mengupload file. Pastikan file valid.");
        }

        return redirect()->to('siswa');
    }

    /**
     * Provide an Excel template for download.
     */
    public function downloadTemplate()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set Headers
        $headers = [
            'NIS',
            'Nama Siswa',
            'Jenis Kelamin',
            'Nama Kelas',
            'Nama Orang Tua',
            'No Whatsapp Ortu',
            'Nama Wali Asrama',
            'No WA Walas',
            'Model Ipad',
            'Warna Ipad',
            'Kondisi Ipad',
            'Status Ipad',
            'Catatan'
        ];
        $sheet->fromArray($headers, NULL, 'A1');

        // Force download
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $filename = 'template_import_siswa.xlsx';

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        $writer->save('php://output');
        exit();
    }

    public function ipad($params = "", $id = ""): string|RedirectResponse
    {
        // Load ClassModel to get class list
        $classModel = new \App\Models\ClassModel();

        if ($params == 'update') {
            $postData = $this->request->getPost();
            $this->ipadModel->update($postData['id'], $postData);
            session()->setFlashdata("success", "Data Role has been successfully updated!");
            return redirect()->to('siswa/ipad');
        } else {
            // Get filter values from GET request
            $classId = $this->request->getGet('class_id');
            $status = $this->request->getGet('status');

            // Check if filters are applied
            if (!empty($classId) || !empty($status)) {
                // Call the new filtered function if filters exist
                $ipadData = $this->ipadModel->getIpadFiltered($classId, $status);
            } else {
                // Call the original function if no filters
                $ipadData = $this->ipadModel->getAllIpad();
            }

            return $this->_renderView('student/ipad', [
                'title' => 'User Ipad',
                'hal' => '6',
                'ipad' => $ipadData,
                'classes' => $classModel->findAll(), // Pass all classes to the view
                'selectedClass' => $classId,         // Pass selected class to the view
                'selectedStatus' => $status,        // Pass selected status to the view
            ]);
        }
    }






    public function scan($params = "", $id = ""): string|RedirectResponse
    {
        if ($params == '') {
            $scanData = $this->scanModel->getAllScan();
            return $this->_renderView('student/scan_list', [
                'title' => 'Scan IPad',
                'hal' => '7',
                'scan' => $scanData,
            ]);
        } elseif ($params == 'Pinjam') {
            $tanggalPengembalian = $this->request->getGet('tanggal_pengembalian');
            $keterangan = $this->request->getGet('keterangan');
            return $this->_renderView('student/scan_pinjam', [
                'title' => 'Scan IPad',
                'hal' => '7',
                'scan' => $params,
                'pengembalian' => $tanggalPengembalian,
                'keterangan' => $keterangan
            ]);
        } else {
            return $this->_renderView('student/scan', [
                'title' => 'Scan IPad',
                'hal' => '7',
                'scan' => $params,
            ]);
        }
    }



    public function resetScan()
    {
        $classId = $this->request->getPost('class_id');
        $status  = $this->request->getPost('status');

        if (!$classId || !$status) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Data tidak lengkap'
            ]);
        }

        $employee = $this->employeeModel
            ->where('id_user', session()->get('id_user'))
            ->first();

        if (!$employee) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Employee tidak ditemukan'
            ]);
        }

        $students = $this->studentModel
            ->select('id, nis')
            ->where('id_class', $classId)
            ->findAll();

        if (empty($students)) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Tidak ada student'
            ]);
        }

        $batchScan = [];
        $nisList   = [];

        foreach ($students as $student) {
            $batchScan[] = [
                'id_employee' => $employee['id'],
                'id_student'  => $student['id'],
                'note'        => 'Reset Group Data',
                'status'      => $status
            ];
            $nisList[] = $student['nis'];
        }

        $db = \Config\Database::connect();
        $db->transStart();

        // Insert scan batch
        $this->scanModel->insertBatch($batchScan);

        // Update iPad sekaligus (1 query)
        if (!empty($nisList)) {
            $this->ipadModel
                ->whereIn('nis', $nisList)
                ->set(['status' => $status])
                ->update();
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->response->setJSON([
                'status'  => false,
                'message' => 'Gagal reset data'
            ]);
        }

        session()->setFlashdata("success", "Update Group Data has been successfully!");
        return redirect()->to('siswa/ipad');
    }




    public function processScan()
    {
        $this->response->setContentType('application/json');

        try {
            // Ambil JSON terlebih dulu, fallback ke POST jika kosong
            $data = $this->request->getJSON(true);
            if (!$data) {
                $data = $this->request->getPost(); // fallback untuk form-encoded
            }

            $qr = $data['qr'] ?? null;
            $method = $data['method'] ?? null; // konsisten: method dari payload JSON atau POST



            if (!$qr) {
                session()->setFlashdata('error', 'QR tidak ditemukan.');
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'QR tidak ditemukan.'
                ]);
            }

            // Validasi QR: ganti sesuai kebutuhan
            $isValid = true;
            if (!$isValid) {
                session()->setFlashdata('error', 'QR tidak valid atau tidak terdaftar.');
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'QR tidak valid atau tidak terdaftar.'
                ]);
            }

            $data_employee = $this->employeeModel->where('id_user', session()->get('id_user'))->first();
            $data_student = $this->studentModel->where('nis', $qr)->first();
            $data_ipad = $this->ipadModel->where('nis', $qr)->first();

            // Find the most recent scan for this student with the same status
            $existingScan = $this->scanModel
                ->where('id_student', $data_student['id'])
                ->where('status', $method)
                ->orderBy('created_at', 'DESC') // Assuming you have a 'created_at' timestamp column
                ->first();

            $isUpdate = false;
            if ($existingScan) {
                $now = new \DateTime();
                $scanTime = new \DateTime($existingScan['created_at']);
                $intervalInSeconds = $now->getTimestamp() - $scanTime->getTimestamp();

                // Check if the scan is within the 3-minute window (180 seconds)
                if ($intervalInSeconds <= 180) {
                    $isUpdate = true;
                }
            }

            if ($method == 'Pinjam') {
                $scanData = [
                    'id_employee' => $data_employee['id'],
                    'id_student' => $data_student['id'],
                    'date' => $data['date'] ?? null,
                    'note' => $data['note'] ?? null,
                    'status' => $method
                ];
            } else {
                $scanData = [
                    'id_employee' => $data_employee['id'],
                    'id_student' => $data_student['id'],
                    'status' => $method
                ];
            }

            // Find the most recent scan for this student to apply the logic
            $lastScan = $this->scanModel
                ->where('id_student', $data_student['id'])
                ->orderBy('created_at', 'DESC') // Assuming 'created_at' is your timestamp column
                ->first();

            // Logic to decide whether to update the last record or create a new one
            if ($lastScan) {
                $isSameStatus = ($lastScan['status'] == $method);

                // Only check time if the status is the same
                if ($isSameStatus) {
                    $now = new \DateTime();
                    $lastScanTime = new \DateTime($lastScan['created_at']);
                    $intervalInSeconds = $now->getTimestamp() - $lastScanTime->getTimestamp();

                    // If status is the same and within 3 minutes (180 seconds), set the ID to update the existing record
                    if ($intervalInSeconds <= 180) {
                        $scanData['id'] = $lastScan['id']; // This will trigger an update on save()
                    }
                }
                // If status is different, or if status is the same but more than 3 minutes ago,
                // do nothing here, which will result in a new record being created.
            }
            // If $lastScan is null (first-ever scan for the student), it will also create a new record.

            $this->scanModel->save($scanData);

            $updateIpad = [
                'status' => $method
            ];
            $this->ipadModel->update($data_ipad['id'], $updateIpad);

            // session()->setFlashdata('success', 'Data berhasil diproses!' . ($method ? ' [' . $method . ']' : ''));

            return $this->response->setJSON([
                'status' => 'success',
                'message' => $data_student['name']
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'processScan error: ' . $e->getMessage());
            session()->setFlashdata('error', 'Terjadi kesalahan server.');
            return $this->response->setJSON([
                'status' => 'error',
                'message' => 'Terjadi kesalahan server.'
            ])->setStatusCode(500);
        }
    }



    public function class($params = "", $id = ""): string|RedirectResponse
    {
        if ($params == 'add') {
            $postData = $this->request->getPost();
            $this->classModel->save($postData);
            session()->setFlashdata("success", "Data Class has been successfully added!");
            return redirect()->to('siswa/kelas');
        } elseif ($params == 'update') {
            $postData = $this->request->getPost();
            $this->classModel->update($postData['id'], $postData);
            session()->setFlashdata("success", "Data Class has been successfully updated!");
            return redirect()->to('siswa/kelas');
        } elseif ($params == 'delete') {
            $this->classModel->delete($id);
            session()->setFlashdata("success", "Data Class has been successfully deleted!");
            return redirect()->to('siswa/kelas');
        } else {
            $classData = $this->classModel->findAll();
            return $this->_renderView('student/class', [
                'title' => 'Kelas',
                'hal' => '8',
                'class' => $classData,
            ]);
        }
    }





    public function history(): string
    {
        // Load models
        $scanModel = new \App\Models\ScanModel();
        $classModel = new \App\Models\ClassModel();

        // Get filter inputs from GET request
        $filters = [
            'class_id'   => $this->request->getGet('class_id'),
            'start_date' => $this->request->getGet('start_date'),
            'end_date'   => $this->request->getGet('end_date'),
            'status'     => $this->request->getGet('status'),
        ];

        // Fetch data from model with filters
        $scanHistory = $scanModel->getScanHistory($filters);

        // Data for view
        $data = [
            'title'       => 'History Scan',
            'hal'         => '9',
            'scanHistory' => $scanHistory,
            'classes'     => $classModel->findAll(), // For class filter dropdown
            'statuses'    => ['Disimpan', 'Pembelajaran', 'Pinjam'], // Define available statuses
            'filters'     => $filters // Send current filters back to the view
        ];

        return $this->_renderView('student/scan_history', $data);
    }

    public function export_pdf()
    {
        ob_start();

        // Load required models
        $scanModel = new \App\Models\ScanModel();

        // Get filter inputs from GET request
        $filters = [
            'class_id'   => $this->request->getGet('class_id'),
            'start_date' => $this->request->getGet('start_date'),
            'end_date'   => $this->request->getGet('end_date'),
            'status'     => $this->request->getGet('status'),
        ];

        // Fetch filtered data
        $scanHistory = $scanModel->getScanHistory($filters);

        // Prepare data for the PDF view
        $data = [
            'title'       => 'Laporan History Scan',
            'scanHistory' => $scanHistory,
        ];

        // Load the view file dan pass data
        $html = view('student/scan_history_pdf', $data);

        // Hapus semua output yang mungkin sudah ada di buffer
        ob_clean();

        // Load PDF library (e.g., Dompdf)
        $dompdf = new \Dompdf\Dompdf();
        $dompdf->loadHtml($html);

        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();

        $dompdf->stream('laporan_history_scan.pdf', ['Attachment' => false]);
        exit();
    }
}
