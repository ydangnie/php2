<?php
// app/controller/CartController.php
class CartController extends Controller {
    private $productModel;
    private $couponModel;
    private $DanhMucModel; 

    public function __construct() {
        $this->productModel = $this->model('ProductModel');
        $this->couponModel = $this->model('MaGiamGiaModel');
        $this->DanhMucModel = $this->model('DanhMucModel'); 
    }

    // 1. Hiển thị giỏ hàng
    public function index() {
        $danhmuc = $this->DanhMucModel->all(); 
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        $total = 0;
        
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        $discount = 0;
        if(isset($_SESSION['coupon'])) {
            $c = $_SESSION['coupon'];
            if($c['loai'] == 'fixed') {
                $discount = $c['gia_tri'];
            } else {
                $discount = $total * ($c['gia_tri'] / 100);
            }
        }

        if($discount > $total) $discount = $total;

        $this->view('view.cart', [
            'cart' => $cart,
            'total' => $total,
            'discount' => $discount,
            'final_total' => $total - $discount,
            'danhmuc' => $danhmuc 
        ]);
    }

    // 2. Thêm vào giỏ hàng
    public function add($id) {
        $product = $this->productModel->find($id);
        if(!$product) {
            header('Location: /cart'); // FIX: Sửa thành /cart
            exit();
        }

        $size = $_POST['size'] ?? 'Mặc định';
        $color = $_POST['color'] ?? 'Mặc định';
        $qty = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

        $cartId = $id . '_' . $size . '_' . $color;

        if(!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

        if(isset($_SESSION['cart'][$cartId])) {
            $_SESSION['cart'][$cartId]['quantity'] += $qty;
        } else {
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
        
        $_SESSION['success'] = "Đã thêm sản phẩm vào giỏ!";
        header('Location: /cart'); // FIX: Đã sửa lại đường dẫn chuẩn
        exit();
    }

    // 3. Cập nhật số lượng
    public function update() {
        if(isset($_POST['qty']) && isset($_SESSION['cart'])) {
            foreach($_POST['qty'] as $encodedCartId => $newQty) {
                // FIX: Giải mã base64 để lấy lại ID chuẩn có dấu cách
                $cartId = base64_decode($encodedCartId); 
                
                if($newQty <= 0) {
                    unset($_SESSION['cart'][$cartId]);
                } elseif (isset($_SESSION['cart'][$cartId])) {
                    $_SESSION['cart'][$cartId]['quantity'] = $newQty;
                }
            }
            $_SESSION['success'] = "Đã cập nhật giỏ hàng!";
        }
        header('Location: /cart');
        exit();
    }

    // 4. Áp dụng mã giảm giá
    public function applyCoupon() {
        if(isset($_POST['code'])) {
            $code = trim($_POST['code']);
            $coupon = $this->couponModel->timTheoMa($code); 
            
            if($coupon && $coupon['so_luong'] > 0) {
                $_SESSION['coupon'] = $coupon;
                $_SESSION['success'] = "Áp dụng mã thành công!";
            } else {
                unset($_SESSION['coupon']);
                $_SESSION['error'] = "Mã không hợp lệ hoặc đã hết hạn!";
            }
        }
        header('Location: /cart');
        exit();
    }

    // FIX: Bổ sung hàm gỡ mã giảm giá bị thiếu
    public function removeCoupon() {
        if(isset($_SESSION['coupon'])) {
            unset($_SESSION['coupon']);
            $_SESSION['success'] = "Đã gỡ mã giảm giá!";
        }
        header('Location: /cart');
        exit();
    }
    
    // 5. Xóa 1 sản phẩm
    public function remove($cartId) {
        // FIX: Giải mã ID lấy từ URL về lại nguyên bản
        $cartIdDecode = base64_decode($cartId); 
        
        if(isset($_SESSION['cart'][$cartIdDecode])) {
            unset($_SESSION['cart'][$cartIdDecode]);
            $_SESSION['success'] = "Đã xóa sản phẩm khỏi giỏ hàng!";
        }
        if(empty($_SESSION['cart'])) unset($_SESSION['coupon']);
        
        header('Location: /cart');
        exit();
    }

    // 6. Xóa hết
    public function clear() {
        unset($_SESSION['cart']);
        unset($_SESSION['coupon']);
        $_SESSION['success'] = "Đã dọn sạch giỏ hàng!";
        header('Location: /cart');
        exit();
    }
}
?>