<?php
class ProfileController extends Controller {
    private $usersModel;
    private $addressModel;

    public function __construct() {
        if (session_status() == PHP_SESSION_NONE) session_start();
        // Chặn không cho khách vãng lai vào
        if (!isset($_SESSION['user'])) {
            header('Location: /auth/login');
            exit();
        }
        $this->usersModel = $this->model('UsersModel');
        $this->addressModel = $this->model('AddressModel');
    }

    // Hiển thị trang Profile
    public function index() {
        $user_id = $_SESSION['user']['id'];
        
        // Lấy thông tin mới nhất từ DB để chắc chắn không bị lệch Session
        $user_info = $this->usersModel->find($user_id); 
        $addresses = $this->addressModel->getByUserId($user_id);

        $this->view('view.profile', [
            'user_info' => $user_info,
            'addresses' => $addresses
        ]);
    }

    // Xử lý cập nhật Tên & Avatar
    public function update() {
        $user_id = $_SESSION['user']['id'];
        $name = trim($_POST['name']);
        
        // Xử lý upload ảnh
        $avatar = $_POST['old_avatar'] ?? 'default-avatar.png';
        if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] == 0) {
            $ext = pathinfo($_FILES['avatar']['name'], PATHINFO_EXTENSION);
            $new_filename = 'avatar_' . $user_id . '_' . time() . '.' . $ext;
            $upload_dir = __DIR__ . '/../../public/uploads/';
            
            if (move_uploaded_file($_FILES['avatar']['tmp_name'], $upload_dir . $new_filename)) {
                $avatar = $new_filename;
            }
        }

        // Cập nhật DB
        $this->usersModel->updateProfile($user_id, $name, $avatar);
        
        // Cập nhật lại Session
        $_SESSION['user']['name'] = $name;
        $_SESSION['success'] = "Cập nhật thông tin thành công!";
        header('Location: /profile');
        exit();
    }

    // Xử lý thêm địa chỉ (Dùng chung cho cả trang Profile và Checkout)
    public function addAddress() {
        $data = [
            'user_id' => $_SESSION['user']['id'],
            'ten_nguoi_nhan' => trim($_POST['ten_nguoi_nhan']),
            'sdt' => trim($_POST['sdt']),
            'dia_chi' => trim($_POST['dia_chi']),
            'is_default' => isset($_POST['is_default']) ? 1 : 0
        ];

        $this->addressModel->addAddress($data);
        $_SESSION['success'] = "Đã thêm địa chỉ mới!";
        
        // Quay lại đúng cái trang mà người dùng vừa thao tác (Profile hoặc Checkout)
        header('Location: ' . $_SERVER['HTTP_REFERER']); 
        exit();
    }
    // Xem lịch sử mua hàng
    public function lichsu() {
        $user_id = $_SESSION['user']['id'];
        
        // Cần truyền user_info để Sidebar hoạt động bình thường
        $user_info = $this->usersModel->find($user_id); 
        
        $orderModel = $this->model('OrderModel');
        $orders = $orderModel->getOrdersByUserId($user_id);

        $this->view('view.lichsu_donhang', [
            'user_info' => $user_info,
            'orders' => $orders
        ]);
    }
    // Xử lý khách hàng tự hủy đơn
    public function huydon($id) {
        if (session_status() == PHP_SESSION_NONE) session_start();
        
        // Chặn khách vãng lai
        if (!isset($_SESSION['user'])) {
            header('Location: /auth/login');
            exit();
        }

        $user_id = $_SESSION['user']['id'];
        $orderModel = $this->model('OrderModel');
        
        // Gọi hàm hủy bên Model
        $result = $orderModel->huyDonHangUser($id, $user_id);
        
        if ($result) {
            $_SESSION['success'] = "Đã hủy đơn hàng #DH" . $id . " thành công!";
        } else {
            $_SESSION['error'] = "Không thể hủy đơn. Đơn hàng này có thể đã được duyệt hoặc không tồn tại.";
        }

        // Quay lại trang lịch sử
        header('Location: /profile/lichsu');
        exit();
    }
}
?>