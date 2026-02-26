<?php
class CheckoutController extends Controller {
    private $orderModel;

    public function __construct() {
        $this->orderModel = $this->model('OrderModel');
    }

    // 1. Hiển thị form checkout
    public function index() {
        if (session_status() == PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['cart'])) {
            $_SESSION['error'] = "Giỏ hàng trống, không thể thanh toán!";
            header("Location: /cart"); exit();
        }

        // Tính tiền
        $total = 0;
        foreach ($_SESSION['cart'] as $item) $total += $item['price'] * $item['quantity'];
        $discount = isset($_SESSION['coupon']) ? ($_SESSION['coupon']['loai'] == 'fixed' ? $_SESSION['coupon']['gia_tri'] : $total * ($_SESSION['coupon']['gia_tri'] / 100)) : 0;
        $final_total = $total - $discount;

        $this->view('view.checkout', [
            'cart' => $_SESSION['cart'],
            'total' => $total,
            'discount' => $discount,
            'final_total' => $final_total
        ]);
    }

    // 2. Xử lý lưu đơn
    public function process() {
        if (session_status() == PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['cart'])) header("Location: /cart");

        // Tính lại tiền an toàn ở backend
        $total = 0;
        foreach ($_SESSION['cart'] as $item) $total += $item['price'] * $item['quantity'];
        $discount = isset($_SESSION['coupon']) ? ($_SESSION['coupon']['loai'] == 'fixed' ? $_SESSION['coupon']['gia_tri'] : $total * ($_SESSION['coupon']['gia_tri'] / 100)) : 0;
        $final_total = $total - $discount;

        $phuong_thuc = $_POST['payment_method'] ?? 'cod';
        
        $data = [
            'user_id' => $_SESSION['user']['id'] ?? null,
            'ten_nguoi_nhan' => trim($_POST['fullname']),
            'sdt' => trim($_POST['phone']),
            'dia_chi' => trim($_POST['address']),
            'ghi_chu' => trim($_POST['note']),
            'tong_tien' => $final_total,
            'phuong_thuc_tt' => $phuong_thuc,
            'trang_thai_tt' => 'chua_thanh_toan'
        ];

        // Lưu DB
        $donhang_id = $this->orderModel->taoDonHang($data, $_SESSION['cart']);

        if ($phuong_thuc == 'vnpay') {
            // GỌI HÀM VNPAY
            $this->thanhToanVNPay($donhang_id, $final_total);
        } else {
            // Thanh toán COD (Tiền mặt)
            unset($_SESSION['cart']);
            unset($_SESSION['coupon']);
            $_SESSION['success'] = "Đặt hàng thành công! Mã đơn của bạn là #DH" . $donhang_id;
            header("Location: /cart"); // Tạm thời redirect về giỏ hàng
        }
    }

    // 3. Xử lý link VNPay
    private function thanhToanVNPay($donhang_id, $amount) {
        $vnp_TmnCode = $_ENV['VNPAY_TMN_CODE'];
        $vnp_HashSecret = $_ENV['VNPAY_HASH_SECRET'];
        $vnp_Url = $_ENV['VNPAY_URL'];
        $vnp_Returnurl = $_ENV['APP_URL'] . "/checkout/vnpayReturn";

        $vnp_TxnRef = $donhang_id; // Mã đơn hàng
        $vnp_OrderInfo = "Thanh toan don hang DH" . $donhang_id;
        $vnp_OrderType = "billpayment";
        $vnp_Amount = $amount * 100; // VNPAY yêu cầu nhân 100
        $vnp_Locale = "vn";
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef
        );

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        
        // Chuyển hướng sang VNPay
        header('Location: ' . $vnp_Url);
        die();
    }

    // 4. Callback từ VNPay trả về
    public function vnpayReturn() {
        if (session_status() == PHP_SESSION_NONE) session_start();
        $vnp_SecureHash = $_GET['vnp_SecureHash'];
        $inputData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashData = $hashData . urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
        }

        $secureHash = hash_hmac('sha512', $hashData, $_ENV['VNPAY_HASH_SECRET']);
        $donhang_id = $_GET['vnp_TxnRef'];

        if ($secureHash == $vnp_SecureHash) {
            if ($_GET['vnp_ResponseCode'] == '00') {
                // Thanh toán thành công
                $this->orderModel->updateTrangThaiThanhToan($donhang_id, 'da_thanh_toan');
                unset($_SESSION['cart']);
                unset($_SESSION['coupon']);
                $_SESSION['success'] = "Thanh toán VNPay thành công cho đơn hàng #DH" . $donhang_id;
            } else {
                $_SESSION['error'] = "Thanh toán VNPay bị hủy hoặc lỗi!";
            }
        } else {
            $_SESSION['error'] = "Chữ ký không hợp lệ, dữ liệu có thể bị giả mạo!";
        }
        header("Location: /cart"); // Tạm thời trả về trang giỏ hàng để báo lỗi/thành công
    }
}
?><?php /**PATH C:\xampp\htdocs\all_php\php11\app\views/view/checkout.blade.php ENDPATH**/ ?>