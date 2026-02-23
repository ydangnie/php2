<?php
// app/controller/CartController.php
class CartController extends Controller {
    private $productModel;
    private $couponModel;
    private $DanhMucModel; // Thêm model danh mục để hiển thị menu

    public function __construct() {
        $this->productModel = $this->model('ProductModel');
        $this->couponModel = $this->model('MaGiamGiaModel');
        // Cần danh mục để hiển thị Header/Nav
        $this->DanhMucModel = $this->model('DanhMucModel'); 
    }

    // 1. Hiển thị giỏ hàng
    public function index() {
        // Lấy danh mục cho Menu (Nav)
        $danhmuc = $this->DanhMucModel->all(); 

        // Lấy giỏ hàng từ Session
        $cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : [];
        $total = 0;
        
        // Tính tổng tiền
        foreach($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }
        
        // Tính giảm giá
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

        // Truyền đầy đủ biến sang View
        $this->view('view.cart', [
            'cart' => $cart,
            'total' => $total,
            'discount' => $discount,
            'final_total' => $total - $discount,
            'danhmuc' => $danhmuc // Truyền danh mục sang view
        ]);
    }

    // 2. Thêm vào giỏ hàng
    public function add($id) {
        $product = $this->productModel->find($id);
        if(!$product) {
            header('Location: view/cart'); // Dùng header thay vì $this->redirect để an toàn
            exit();
        }

        $size = $_POST['size'] ?? 'Mặc định';
        $color = $_POST['color'] ?? 'Mặc định';
        $qty = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

        // ID giỏ hàng kết hợp: id_size_color
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
        header('Location: /cart'); // Chuyển hướng về URL /cart
        exit();
    }

    // 3. Cập nhật số lượng
    public function update() {
        if(isset($_POST['qty']) && isset($_SESSION['cart'])) {
            foreach($_POST['qty'] as $cartId => $newQty) {
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
            $coupon = $this->couponModel->timTheoMa($code); // Đảm bảo model có hàm này
            
            if($coupon && $coupon['so_luong'] > 0) {
                $_SESSION['coupon'] = $coupon;
                $_SESSION['success'] = "Áp dụng mã thành công!";
            } else {
                unset($_SESSION['coupon']);
                $_SESSION['error'] = "Mã không hợp lệ!";
            }
        }
        header('Location: /cart');
        exit();
    }
    
    // 5. Xóa 1 sản phẩm
    public function remove($cartId) {
        if(isset($_SESSION['cart'][$cartId])) {
            unset($_SESSION['cart'][$cartId]);
        }
        if(empty($_SESSION['cart'])) unset($_SESSION['coupon']);
        
        header('Location: /cart');
        exit();
    }

    // 6. Xóa hết
    public function clear() {
        unset($_SESSION['cart']);
        unset($_SESSION['coupon']);
        header('Location: /cart');
        exit();
    }
}
?>