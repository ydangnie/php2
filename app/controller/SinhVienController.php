<?php
class SinhVienController extends Controller {
    private $SinhVienModel;
private $thongbao;
    public function __construct() {
        $this->SinhVienModel = $this->model('SinhVienModel');
    }

 public function index() {
        // Kiểm tra xem có từ khóa tìm kiếm trên URL không
        if (isset($_GET['tukhoa']) && !empty($_GET['tukhoa'])) {
            $tukhoa = $_GET['tukhoa'];
            $sinhvien = $this->SinhVienModel->timKiem($tukhoa);
        } else {
            // Nếu không tìm kiếm, lấy tất cả danh sách
            $sinhvien = $this->SinhVienModel->all();
            $tukhoa = "";
        }
        
        // Truyền biến $keyword qua view để giữ lại giá trị trong ô input sau khi tìm (UX tốt hơn)
        $data = ['sinhvien' => $sinhvien];
        if (isset($tukhoa)) {
            $data['tukhoa'] = $tukhoa;
        }

       $this->view('sinhvien/index', [
            'sinhvien' => $sinhvien,
            'tukhoa' => $tukhoa
        ]);
    }

    public function them() {
      
        $this->view('sinhvien/them', []); 
    }

    public function luu() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $mssv = $_POST['mssv'];
            $hotensv = $_POST['hotensv'];
            $nganh = $_POST['nganh'];
            if(empty($mssv) || empty($hotensv) || empty($nganh)){
                echo "Dữ liệu không được để trống";
                return;
            }
            $this->SinhVienModel->create(['mssv' => $mssv, 'hotensv' => $hotensv, 'nganh' => $nganh]);
         $_SESSION['thongbao'] = "Thêm sinh viên thành công";
            $this->redirect('http://localhost:8000/sinhvien/index'); 
           
        }
    }
    public function edit($id) {
        $sinhvien = $this->SinhVienModel->find($id);
   
        $this->view('sinhvien/edit', ['sinhvien' => $sinhvien]); 
    }
    public function update_sinhvien($id) {
         if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $mssv = $_POST['mssv'];
            $hotensv = $_POST['hotensv'];
            $nganh = $_POST['nganh'];
            $this->SinhVienModel->update(['mssv' => $mssv, 'hotensv' => $hotensv, 'nganh' => $nganh], $id);
            $_SESSION['thongbao'] = "Cập nhật sinh viên thành công";
             $this->redirect('http://localhost:8000/sinhvien/index'); 
        }
    }

    public function delete($id) {
        $this->SinhVienModel->delete($id);
        $_SESSION['thongbao'] = "Xóa sinh viên thành công";
         $this->redirect('http://localhost:8000/sinhvien/index'); 
    }
    public function test() {
        // Gọi đến file view bạn vừa sửa
        $this->view('sinhvien/sinhvien', []); 
    }
}