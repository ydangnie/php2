<?php
// app/controller/ViewController.php

class ViewController extends Controller
{

    private $productModel;
    private $DanhMucModel;

    public function __construct()
    {
        $this->productModel = $this->model('ProductModel');
        $this->DanhMucModel = $this->model('DanhMucModel');
    }
    public function index()
    {
        $danhmuc = $this->DanhMucModel->all();
        $products = $this->productModel->all();
        $this->view('view.index', ['products' => $products, 'danhmuc' => $danhmuc]);
    }

    public function sanpham()
    {
        // 1. Cấu hình phân trang
        $limit = 20; // 20 sản phẩm 1 trang
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $limit;

        // 2. Lấy giá trị bộ lọc từ URL
        $category_id = isset($_GET['category']) ? $_GET['category'] : null;
        $min_price = isset($_GET['min_price']) ? $_GET['min_price'] : null;
        $max_price = isset($_GET['max_price']) ? $_GET['max_price'] : null;

        // 3. Truy vấn dữ liệu
        $danhmuc = $this->DanhMucModel->all();
        $products = $this->productModel->getFilteredProducts($limit, $offset, $category_id, $min_price, $max_price);

        $totalProducts = $this->productModel->countFilteredProducts($category_id, $min_price, $max_price);
        $totalPages = ceil($totalProducts / $limit);

        // 4. Trả về View (tạo file sanpham.blade.php trong thư mục view)
        $this->view('view.sanpham', [
            'products' => $products,
            'danhmuc' => $danhmuc,
            'totalPages' => $totalPages,
            'currentPage' => $page,
            'category_id' => $category_id,
            'min_price' => $min_price,
            'max_price' => $max_price
        ]);
    }

    // Trang chi tiết sản phẩm
    public function chitiet($id)
    {
        $product = $this->productModel->find($id);
        if (!$product) {
            die("Sản phẩm không tồn tại!");
        }

        // --- BẮT ĐẦU: LƯU SẢN PHẨM ĐÃ XEM VÀO SESSION ---
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['da_xem'])) {
            $_SESSION['da_xem'] = [];
        }
        // Nếu id chưa có trong mảng thì thêm vào đầu mảng
        if (!in_array($id, $_SESSION['da_xem'])) {
            array_unshift($_SESSION['da_xem'], $id);
        }
        // Giữ lại tối đa 8 sản phẩm đã xem gần nhất để nhẹ bộ nhớ
        if (count($_SESSION['da_xem']) > 8) {
            array_pop($_SESSION['da_xem']);
        }
        // --- KẾT THÚC ---

        $bienthe = $this->productModel->getBienthe($id);
        $relatedProducts = [];
        if (!empty($product['danhmuc_id'])) {
            $relatedProducts = $this->productModel->getRelatedProducts($product['danhmuc_id'], $id, 4);
        }

        $this->view('view.chitiet', [
            'product' => $product,
            'bienthe' => $bienthe,
            'relatedProducts' => $relatedProducts
        ]);
    }
    public function thetym($id)
    {
        if (session_status() == PHP_SESSION_NONE) session_start();
        
        // Bắt buộc đăng nhập mới được tym
        if (!isset($_SESSION['user'])) {
            // Chuyển hướng về đăng nhập kèm thông báo
            $_SESSION['error'] = "Bạn cần đăng nhập để yêu thích sản phẩm!";
            header("Location: /auth/login");
            exit();
        }

        $user_id = $_SESSION['user']['id'];
        $status = $this->productModel->toggleYeuThich($user_id, $id);

        if ($status == 'added') {
            $_SESSION['success'] = "Đã thêm vào danh sách yêu thích!";
        } else {
            $_SESSION['success'] = "Đã bỏ yêu thích sản phẩm!";
        }
        
        // Quay lại trang trước đó
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
    public function timkiem()
    {
        $tukhoa = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';
        
        if (empty($tukhoa)) {
            $products = [];
            $thongbao = "Vui lòng nhập từ khóa tìm kiếm.";
        } else {
            // Dùng hàm timKiem đã có trong model của bạn
            $products = $this->productModel->timKiem($tukhoa);
            $thongbao = "Tìm thấy " . count($products) . " sản phẩm cho từ khóa: '" . htmlspecialchars($tukhoa) . "'";
        }

        // Tận dụng lại view sanpham.blade.php để hiển thị (tái sử dụng code)
        $danhmuc = $this->DanhMucModel->all(); 
        $this->view('view.sanpham', [
            'products' => $products,
            'danhmuc' => $danhmuc,
            'thongbao' => $thongbao, // Truyền thông báo ra view
            'currentPage' => 1,
            'totalPages' => 1 // Tạm thời bỏ qua phân trang ở tìm kiếm để code đơn giản
        ]);
    }
    public function yeuthich()
    {
        if (session_status() == PHP_SESSION_NONE) session_start();
        
        // Bắt buộc đăng nhập mới xem được trang này
        if (!isset($_SESSION['user'])) {
            $_SESSION['error'] = "Bạn cần đăng nhập để xem danh sách yêu thích!";
            header("Location: /auth/login");
            exit();
        }

        $user_id = $_SESSION['user']['id'];
        $products = $this->productModel->getDanhSachYeuThich($user_id);

        $this->view('view.yeuthich', [
            'products' => $products
        ]);
    }
    // Trang Sản phẩm đã xem gần đây
    public function daxem()
    {
        if (session_status() == PHP_SESSION_NONE) session_start();
        
        $products = [];
        // Kiểm tra xem session 'da_xem' có tồn tại và có dữ liệu không
        if (isset($_SESSION['da_xem']) && !empty($_SESSION['da_xem'])) {
            $ids = $_SESSION['da_xem'];
            // Gọi Model để lấy chi tiết các sản phẩm này
            $products = $this->productModel->getProductsByIds($ids);
        }

        $this->view('view.daxem', [
            'products' => $products
        ]);
    }
}
