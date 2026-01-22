<?php

class ProductsController extends Controller
{
    private $productModel;

    public function __construct()
    {
        $this->productModel = $this->model('ProductModel');
    }

    public function index()
    {
           // Kiểm tra xem có từ khóa tìm kiếm trên URL không
        if (isset($_GET['tukhoa']) && !empty($_GET['tukhoa'])) {
            $tukhoa = $_GET['tukhoa'];
            $products = $this->productModel->timKiem($tukhoa);
        } else {
            // Nếu không tìm kiếm, lấy tất cả danh sách
            $products = $this->productModel->all();
            $tukhoa = "";
        }
        
        // Truyền biến $keyword qua view để giữ lại giá trị trong ô input sau khi tìm (UX tốt hơn)
        $data = ['sinhvien' => $products];
        if (isset($tukhoa)) {
            $data['tukhoa'] = $tukhoa;
        }

       $this->view('products/index', [
            'products' => $products,
            'tukhoa' => $tukhoa
        ]);
    }

    public function add()
    {

        $this->view('products/add', []);
    }

    public function them()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $mota = $_POST['mota'];
            
            if (isset($_FILES['img']) && $_FILES['img']['error'] === 0) {
                $img =  $_FILES['img']['name'];
                $thumuc = "uploads/";
                $thumucluu = $thumuc . basename($img);
                move_uploaded_file($_FILES['img']['tmp_name'], $thumucluu);
            }
            $this->productModel->create(['name' => $name, 'price' => $price, 'mota' => $mota, 'img' => $img]);
            $_SESSION['thongbao'] = "Thêm sản phẩm thành công";
            $this->redirect('http://localhost:8000/products/index');
        }
    }
    public function edit($id)
    {
        $product = $this->productModel->find($id);
        $this->view('products/edit', ['product' => $product]);
    }

    public function update_product($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $mota = $_POST['mota'];
            $img = "";
            if (isset($_FILES['img']) && $_FILES['img']['error'] === 0) {
                $img =  $_FILES['img']['name'];
                $thumuc = "uploads/";
                $thumucluu = $thumuc . basename($img);
                move_uploaded_file($_FILES['img']['tmp_name'], $thumucluu);
            }
            $this->productModel->update(['name' => $name, 'price' => $price, 'mota' => $mota, 'img' => $img], $id);
            $_SESSION['thongbao'] = "Cập nhật sản phẩm thành công";
            $this->redirect('http://localhost:8000/products/index');
        }
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
