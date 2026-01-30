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

            $products = $this->productModel->all();

            $tukhoa = "";


            $products = $this->productModel->phantrang($offset, $limit);
        }

        $data = ['products' => $products];
        if (isset($tukhoa)) {
            $data['tukhoa'] = $tukhoa;
        }
        $this->view('products/index', [
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
        $this->view('products/add', ['danhmuc' => $danhmuc, 'thuonghieu' => $thuonghieu]);
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

            if (isset($_FILES['img']) && $_FILES['img']['error'] === 0) {
                $img =  $_FILES['img']['name'];
                $thumuc = "uploads/";
                $thumucluu = $thumuc . basename($img);
                move_uploaded_file($_FILES['img']['tmp_name'], $thumucluu);
            }
            $this->productModel->create([
                'name' => $name,
                'price' => $price,
                'mota' => $mota,
                'img' => $img,
                'danhmuc_id' => $danhmuc_id,
                'thuonghieu_id' => $thuonghieu_id,
                'soluong' => $soluong
            ]);

            $_SESSION['thongbao'] = "Thêm sản phẩm thành công";
            $this->redirect('http://localhost:8000/products/index');
        }
    }
    public function edit($id)
    {
        $product = $this->productModel->find($id);
        $alldanhmuc = $this->DanhMucModel->all();
        $allthuonghieu = $this->ThuongHieuModel->all();
        $this->view('products/edit', ['product' => $product, 'danhmuc' => $alldanhmuc, 'thuonghieu' => $allthuonghieu]);
    }

    public function update_product($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $price = $_POST['price'];
            $mota = $_POST['mota'];
            $img = "";
            $danhmuc_id = $_POST['danhmuc_id'];
            $thuonghieu_id = $_POST['thuonghieu_id'];
            $soluong = $_POST['soluong'];


            
           if (isset($_FILES['img']) && $_FILES['img']['error'] === 0) {
                $img =  $_FILES['img']['name'];
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
