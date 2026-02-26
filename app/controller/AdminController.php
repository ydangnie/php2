<?php

class AdminController extends Controller
{
    private $productModel;
    private $userModel;
    // private $orderModel; // Nếu có

    public function __construct()
    {
        // Gọi các model cần thiết để đếm số liệu
        $this->productModel = $this->model('ProductModel');
        $this->userModel = $this->model('UsersModel');
    }

    public function dashboard()
    {
        // 1. Lấy số lượng thống kê
        $countProducts = $this->productModel->countAll(); // Hàm này bạn đã có trong ProductModel
        $countUsers = 10; // Ví dụ, bạn cần viết thêm hàm countAll() trong UsersModel
        $countOrders = 5; // Ví dụ giả định

        $recentProducts = $this->productModel->phantrang(0, 5); 

        // 3. Truyền data ra View
        $this->view('admin/dashboard', [
            'countProducts' => $countProducts,
            'countUsers' => $countUsers,
            'countOrders' => $countOrders,
            'recentProducts' => $recentProducts
        ]);
    }
    // --- THÊM VÀO TRONG AdminController ---

    // Danh sách đơn hàng
    public function donhang() {
        $orderModel = $this->model('OrderModel');
        $orders = $orderModel->getAllOrders();
        $this->view('admin.donhang.index', ['orders' => $orders]);
    }

    // Xem chi tiết đơn hàng
    public function chitietDonHang($id) {
        $orderModel = $this->model('OrderModel');
        $order = $orderModel->getOrderById($id);
        
        if(!$order) {
            die("Đơn hàng không tồn tại!");
        }

        $details = $orderModel->getOrderDetails($id);
        $this->view('admin.donhang.chitiet', [
            'order' => $order, 
            'details' => $details
        ]);
    }

    // Cập nhật trạng thái đơn
    // Cập nhật trạng thái đơn
    public function capNhatDonHang($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (session_status() == PHP_SESSION_NONE) session_start();
            $orderModel = $this->model('OrderModel');
            
            // 1. Lấy trạng thái hiện tại của đơn hàng từ Database
            $order = $orderModel->getOrderById($id);
            $trang_thai_hien_tai = $order['trang_thai_don'];
            
            // 2. Lấy dữ liệu Admin gửi lên
            // Nếu thẻ select bị disabled, biến $_POST['trang_thai_don'] sẽ không tồn tại, ta lấy lại trạng thái cũ
            $tt_don = $_POST['trang_thai_don'] ?? $trang_thai_hien_tai; 
            $tt_tt = $_POST['trang_thai_tt'] ?? $order['trang_thai_tt'];
            
            // 3. LOGIC KIỂM TRA (VALIDATE LÙI TRẠNG THÁI)
            $hop_le = true;
            $loi = "";

            if ($trang_thai_hien_tai == 'hoan_thanh' && $tt_don != 'hoan_thanh') {
                $hop_le = false;
                $loi = "Đơn hàng đã hoàn thành, không thể quay ngược trạng thái!";
            } elseif ($trang_thai_hien_tai == 'da_huy' && $tt_don != 'da_huy') {
                $hop_le = false;
                $loi = "Đơn hàng đã hủy, không thể khôi phục trạng thái!";
            } elseif ($trang_thai_hien_tai == 'dang_giao' && $tt_don == 'cho_xac_nhan') {
                $hop_le = false;
                $loi = "Đơn hàng đang giao, không thể lùi về chờ xác nhận!";
            }

            // 4. Xử lý kết quả
            if (!$hop_le) {
                $_SESSION['error'] = $loi;
            } else {
                $orderModel->updateTrangThaiDon($id, $tt_don, $tt_tt);
                $_SESSION['success'] = "Đã cập nhật trạng thái đơn hàng #DH" . $id;
            }
            
            header("Location: /admin/chitietDonHang/" . $id);
            exit();
        }
    }
}