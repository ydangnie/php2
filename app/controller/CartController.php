<?php
class CartController extends Controller {
    private $productModel;
    private $couponModel;

    public function __construct() {
        $this->productModel = $this->model('ProductModel');
        $this->couponModel = $this->model('CouponModel');
    }

    public function index() {
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        $total = 0;
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        // Tính giảm giá
        $discount = 0;
        if(isset($_SESSION['coupon'])) {
            $c = $_SESSION['coupon'];
            if($c['loai'] == 1) $discount = $c['giam_gia']; // Trừ tiền
            else $discount = $total * ($c['giam_gia'] / 100); // Trừ %
        }

        $this->view('client.cart', [
            'cart' => $cart,
            'total' => $total,
            'discount' => $discount,
            'final_total' => $total - $discount
        ]);
    }

    public function add($id) {
        $product = $this->productModel->find($id);
        if(!$product) return;

        // Lấy biến thể (nếu có chọn size/color từ form)
        $size = $_POST['size'] ?? 'Mặc định';
        $color = $_POST['color'] ?? 'Mặc định';

        $cartId = $id . '_' . $size . '_' . $color; // ID giỏ hàng kết hợp thuộc tính

        if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

        if(isset($_SESSION['cart'][$cartId])) {
            $_SESSION['cart'][$cartId]['quantity']++;
        } else {
            $_SESSION['cart'][$cartId] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'price' => $product['price'],
                'img' => $product['img'],
                'size' => $size,
                'color' => $color,
                'quantity' => 1
            ];
        }
        $this->redirect('/cart');
    }

    public function applyCoupon() {
        if($_POST['code']) {
            $coupon = $this->couponModel->findByCode($_POST['code']);
            if($coupon && $coupon['soluong'] > 0) {
                $_SESSION['coupon'] = $coupon;
                $_SESSION['success'] = "Áp dụng mã thành công!";
            } else {
                $_SESSION['error'] = "Mã không hợp lệ hoặc hết hạn!";
            }
        }
        $this->redirect('/cart');
    }
    
    public function remove($id) {
        if(isset($_SESSION['cart'][$id])) {
            unset($_SESSION['cart'][$id]);
        }
        $this->redirect('/cart');
    }
}