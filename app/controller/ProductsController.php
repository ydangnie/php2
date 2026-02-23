<?php

class ProductsController extends Controller
{
    private $productModel;
    private $ThuongHieuModel;
    private $DanhMucModel;

    public function __construct()
    {
        $this->DanhMucModel = $this->model('DanhMucModel');
        $this->ThuongHieuModel = $this->model('ThuongHieuModel');
        $this->productModel = $this->model('ProductModel');
    }
    
    public function index()
    {
        $limit = 5;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $limit;
        $totalProduct = $this->productModel->countAll();
        $totalPages = ceil($totalProduct / $limit);

        if (isset($_GET['tukhoa']) && !empty($_GET['tukhoa'])) {
            $tukhoa = $_GET['tukhoa'];
            $products = $this->productModel->timKiem($tukhoa);
        } else {
            $products = $this->productModel->all(); // Dòng này có thể thừa nếu dùng phân trang bên dưới, nhưng giữ nguyên logic cũ của bạn
            $tukhoa = "";
            $products = $this->productModel->phantrang($offset, $limit);
        }

        $data = ['products' => $products];
        if (isset($tukhoa)) {
            $data['tukhoa'] = $tukhoa;
        }
        $this->view('admin/products/index', [
            'products' => $products,
            'tukhoa' => $tukhoa,
            'totalPages' => $totalPages,
            'page' => $page
        ]);
    }

    public function add()
    {
        $danhmuc = $this->DanhMucModel->all();
        $thuonghieu = $this->ThuongHieuModel->all();
        $this->view('admin/products/add', ['danhmuc' => $danhmuc, 'thuonghieu' => $thuonghieu]);
    }

    public function them()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $mota = $_POST['mota'];
            $danhmuc_id = $_POST['danhmuc_id'];
            $thuonghieu_id = $_POST['thuonghieu_id'];
            $soluong = $_POST['soluong'];
            $img = "";

            if (isset($_FILES['img']) && $_FILES['img']['error'] === 0) {
                $img =  time() . "_" . $_FILES['img']['name']; // Thêm time() để tránh trùng tên
                $thumuc = "uploads/";
                $thumucluu = $thumuc . basename($img);
                move_uploaded_file($_FILES['img']['tmp_name'], $thumucluu);
            }
            
            // 1. Tạo sản phẩm và LẤY ID vừa tạo
            $product_id = $this->productModel->create([
                'name' => $name,
                'price' => $price,
                'mota' => $mota,
                'img' => $img,
                'danhmuc_id' => $danhmuc_id,
                'thuonghieu_id' => $thuonghieu_id,
                'soluong' => $soluong
            ]);

            // 2. Nếu tạo thành công & có biến thể, thêm biến thể
            if ($product_id && isset($_POST['variants_size'])) {
                $sizes = $_POST['variants_size'];
                $colors = $_POST['variants_color'];
                $quantities = $_POST['variants_soluong'];
                
                for ($i = 0; $i < count($sizes); $i++) {
                    // Xử lý ảnh riêng cho từng biến thể
                    $variant_img = "";
                    if (isset($_FILES['variants_img']['name'][$i]) && $_FILES['variants_img']['error'][$i] == 0) {
                        $target_dir = "uploads/";
                        $variant_img = time() . "_var_" . $i . "_" . basename($_FILES['variants_img']['name'][$i]);
                        move_uploaded_file($_FILES['variants_img']['tmp_name'][$i], $target_dir . $variant_img);
                    }

                    $this->productModel->addBienthe([
                        'id_products' => $product_id,
                        'size' => $sizes[$i],
                        'color' => $colors[$i],
                        'soluong' => $quantities[$i],
                        'img' => $variant_img
                    ]);
                }
            }

            $_SESSION['thongbao'] = "Thêm sản phẩm thành công";
            $this->redirect('http://localhost:8000/products/index'); // Sửa lại đường dẫn cho đúng router của bạn
        }
    }

    public function edit($id)
    {
        $product = $this->productModel->find($id);
        $alldanhmuc = $this->DanhMucModel->all();
        $allthuonghieu = $this->ThuongHieuModel->all();
        
        // Lấy danh sách biến thể
        $bienthe = $this->productModel->getBienthe($id);

        $this->view('admin/products/edit', [
            'product' => $product, 
            'danhmuc' => $alldanhmuc, 
            'thuonghieu' => $allthuonghieu,
            'bienthe' => $bienthe // Truyền biến thể qua view
        ]);
    }

    public function update_product($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $mota = $_POST['mota'];
            $danhmuc_id = $_POST['danhmuc_id'];
            $thuonghieu_id = $_POST['thuonghieu_id'];
            $soluong = $_POST['soluong'];
            
            // Lấy ảnh cũ nếu không up ảnh mới
            $currentProduct = $this->productModel->find($id);
            $img = $currentProduct['img'];

            if (isset($_FILES['img']) && $_FILES['img']['error'] === 0) {
                $img =  time() . "_" . $_FILES['img']['name'];
                $thumuc = "uploads/";
                $thumucluu = $thumuc . basename($img);
                move_uploaded_file($_FILES['img']['tmp_name'], $thumucluu);
            }
            
            $this->productModel->update([
                'name' => $name,
                'price' => $price,
                'mota' => $mota,
                'img' => $img,
                'danhmuc_id' => $danhmuc_id,
                'thuonghieu_id' => $thuonghieu_id,
                'soluong' => $soluong
            ], $id);

            $_SESSION['thongbao'] = "Cập nhật sản phẩm thành công";
            $this->redirect('http://localhost:8000/products/index');
        }
    }

   
    public function add_variant_single($product_id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
             $img = "";
             if (isset($_FILES['new_variant_img']) && $_FILES['new_variant_img']['error'] == 0) {
                 $target_dir = "uploads/";
                 $img = time() . "_single_" . basename($_FILES["new_variant_img"]["name"]);
                 move_uploaded_file($_FILES["new_variant_img"]["tmp_name"], $target_dir . $img);
             }

             $this->productModel->addBienthe([
                'id_products' => $product_id,
                'size' => $_POST['new_size'],
                'color' => $_POST['new_color'],
                'soluong' => $_POST['new_soluong'],
                'img' => $img
            ]);
            
            $this->redirect('http://localhost:8000/products/edit/' . $product_id);
        }
    }

    // Xóa biến thể
    public function delete_variant($id) {        
        $product_id = $_GET['product_id']; // Lấy từ query string
        $this->productModel->deleteBienthe($id);
        
        $this->redirect('http://localhost:8000/products/edit/' . $product_id);
    }

    public function delete($id)
    {
        $product = $this->productModel->find($id);

        $this->productModel->delete($id);
        if ($product) {
            if (!empty($product['img'])) {
                $hinhanhxoa = 'uploads/' . $product['img'];
                if (file_exists($hinhanhxoa)) {
                    unlink($hinhanhxoa);
                }
            }
        }

        $this->redirect('http://localhost:8000/products/index');
    }
}
?>