<?php

class MaGiamGiaController extends Controller {
    private $model;

    public function __construct() {
        // Gọi Model vừa tạo ở trên
        $this->model = $this->model('MaGiamGiaModel');
    }

    // --- TRANG DANH SÁCH ---
    // URL chạy: /magiamgia/index
    public function index() {
        $ds_ma = $this->model->layDanhSach();
        // Truyền dữ liệu sang View
        $this->view('admin.magiamgia.index', ['ds_ma' => $ds_ma]);
    }

    // --- TRANG THÊM MỚI ---
    // URL chạy: /magiamgia/them
    public function them() {
        $this->view('admin.magiamgia.them');
    }

    // --- XỬ LÝ LƯU KHI THÊM ---
    // URL chạy: /magiamgia/luu (POST)
    public function luu() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Lấy mã code và viết hoa nó lên (ví dụ: tet2025 -> TET2025)
            $ma_code = strtoupper(trim($_POST['ma_code']));

            // 1. Kiểm tra trùng mã
            if ($this->model->kiemTraTrungMa($ma_code)) {
                echo "<script>alert('Mã này đã tồn tại rồi! Vui lòng chọn mã khác.'); window.history.back();</script>";
                return;
            }

            // 2. Chuẩn bị dữ liệu đúng tên cột trong Database
            $dulieu = [
                'ma_code'      => $ma_code,
                'loai'         => $_POST['loai'],          // 'fixed' hoặc 'percent'
                'gia_tri'      => $_POST['gia_tri'],
                'so_luong'     => $_POST['so_luong'],
                'ngay_het_han' => $_POST['ngay_het_han'],
                'trang_thai'   => isset($_POST['trang_thai']) ? 1 : 0 // Nếu tích thì là 1, không tích là 0
            ];

            // 3. Gọi model lưu lại
            if ($this->model->themMoi($dulieu)) {
                // Thành công thì về trang danh sách
                header('Location: /magiamgia/index');
            } else {
                echo "Lỗi hệ thống, không lưu được!";
            }
        }
    }

    // --- TRANG SỬA ---
    // URL chạy: /magiamgia/sua/1
    public function sua($id) {
        // Lấy thông tin cũ để điền vào form
        $ma = $this->model->layChiTiet($id);
        
        if (!$ma) {
            echo "Mã giảm giá không tồn tại!";
            return;
        }

        $this->view('admin.magiamgia.sua', ['ma' => $ma]);
    }

    // --- XỬ LÝ CẬP NHẬT ---
    // URL chạy: /magiamgia/capnhat/1 (POST)
    public function capnhat($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $dulieu = [
                'ma_code'      => strtoupper(trim($_POST['ma_code'])),
                'loai'         => $_POST['loai'],
                'gia_tri'      => $_POST['gia_tri'],
                'so_luong'     => $_POST['so_luong'],
                'ngay_het_han' => $_POST['ngay_het_han'],
                'trang_thai'   => isset($_POST['trang_thai']) ? 1 : 0
            ];

            if ($this->model->capNhat($id, $dulieu)) {
                header('Location: /magiamgia/index');
            } else {
                echo "Lỗi cập nhật!";
            }
        }
    }

    // --- XÓA MÃ ---
    // URL chạy: /magiamgia/xoa/1
    public function xoa($id) {
        $this->model->xoa($id);
        header('Location: /magiamgia/index');
    }
}