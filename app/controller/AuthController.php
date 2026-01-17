<?php
class AuthController extends Controller {
    private $authmodel;

    public function __construct() {
        $this->authmodel = $this->model('AthModel');
    }

    public function index() {
        $products = $this->authmodel->all();
        // Sửa 'product' thành 'products'
        $this->view('products/index', ['products' => $products]); 
    }

    public function add() {
      
        $this->view('login/dangky', []); 
    }

    public function dangky() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ten = $_POST['ten'];
            $matkhau = $_POST['matkhau'];
            $this->authmodel->create(['ten' => $ten, 'matkhau' => $matkhau]);
        
            $this->redirect('localhost:8000/login/index'); 
        }
    }
}