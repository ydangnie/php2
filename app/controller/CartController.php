<?php
class CartController extends Controller {
    private $productModel;
    private $couponModel;

    public function __construct() {
        $this->productModel = $this->model('ProductModel');
        // Gọi đúng tên Model mã giảm giá chúng ta đã tạo
        $this->couponModel = $this->model('MaGiamGiaModel');
    }

    // 1. Hiển thị giỏ hàng
    public function index() {
        // Lấy giỏ hàng từ Session, nếu chưa có thì là mảng rỗng
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        $total = 0;
        
        // Tính tổng tiền hàng
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        // Tính giảm giá (Nếu có mã)
        $discount = 0;
        if(isset($_SESSION['coupon'])) {
            $c = $_SESSION['coupon'];
            
            if($c['loai'] == 'fixed') {
                // Giảm theo số tiền cố định
                $discount = $c['gia_tri'];
            } else {
                // Giảm theo phần trăm (VD: 10%)
                $discount = $total * ($c['gia_tri'] / 100);
            }
        }

        // Đảm bảo số tiền giảm không vượt quá tổng tiền
        if($discount > $total) $discount = $total;

        $this->view('view.cart', [
            'cart' => $cart,
            'total' => $total,
            'discount' => $discount,
            'final_total' => $total - $discount
        ]);
    }

    // 2. Thêm vào giỏ hàng
    public function add($id) {
        $product = $this->productModel->find($id);
        if(!$product) {
            $this->redirect('/'); // Không tìm thấy sp thì về trang chủ
            return;
        }

        // Lấy thông tin size/màu từ form (nếu có)
        $size = $_POST['size'] ?? 'Mặc định';
        $color = $_POST['color'] ?? 'Mặc định';
        $qty = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

        // Tạo ID riêng cho từng biến thể (VD: 10_L_Do)
        $cartId = $id . '_' . $size . '_' . $color;

        if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

        // Nếu sản phẩm đã có trong giỏ -> Cộng thêm số lượng
        if(isset($_SESSION['cart'][$cartId])) {
            $_SESSION['cart'][$cartId]['quantity'] += $qty;
        } else {
            // Chưa có thì thêm mới
            $_SESSION['cart'][$cartId] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'img' => $product['img'],
                'size' => $size,
                'color' => $color,
                'quantity' => $qty
            ];
        }
        
        $_SESSION['success'] = "Đã thêm " . $product['name'] . " vào giỏ!";
        $this->redirect('view/cart'); // Chuyển hướng về trang giỏ hàng
    }

    // 3. Cập nhật số lượng (Khi bấm nút Cập nhật trong giỏ)
    public function update() {
        if(isset($_POST['qty']) && isset($_SESSION['cart'])) {
            // $_POST['qty'] là mảng: ['cartId1' => 2, 'cartId2' => 5]
            foreach($_POST['qty'] as $cartId => $newQty) {
                if($newQty <= 0) {
                    unset($_SESSION['cart'][$cartId]); // Số lượng <= 0 thì xóa luôn
                } elseif (isset($_SESSION['cart'][$cartId])) {
                    $_SESSION['cart'][$cartId]['quantity'] = $newQty;
                }
            }
            $_SESSION['success'] = "Đã cập nhật giỏ hàng!";
        }
        $this->redirect('view/cart');
    }

    // 4. Áp dụng mã giảm giá
    public function applyCoupon() {
        if(isset($_POST['code'])) {
            $code = trim($_POST['code']);
            $coupon = $this->couponModel->timTheoMa($code);
            
            if($coupon && $coupon['so_luong'] > 0) {
                $_SESSION['coupon'] = $coupon;
                $_SESSION['success'] = "Áp dụng mã giảm giá thành công!";
            } else {
                // Xóa coupon cũ nếu nhập sai
                unset($_SESSION['coupon']);
                $_SESSION['error'] = "Mã không hợp lệ, hết hạn hoặc đã hết lượt dùng!";
            }
        }
        $this->redirect('view/cart');
    }
    
    // 5. Xóa 1 sản phẩm
    public function remove($cartId) {
        if(isset($_SESSION['cart'][$cartId])) {
            unset($_SESSION['cart'][$cartId]);
        }
        
        // Nếu xóa hết sản phẩm thì xóa luôn mã giảm giá
        if(empty($_SESSION['cart'])) {
            unset($_SESSION['coupon']);
        }
        
        $this->redirect('view/cart');
    }

    // 6. Xóa toàn bộ giỏ
    public function clear() {
        unset($_SESSION['cart']);
        unset($_SESSION['coupon']);
        $this->redirect('view/cart');
    }
}