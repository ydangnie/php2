<?php

class UsersController extends Controller
{
    private $UsersModel;

    public function __construct()
    {
        $this->UsersModel = $this->model('UsersModel');
    }

    public function index()
    {
        $users = $this->UsersModel->all();
   
        $limit = 5;
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;
        $offset = ($page - 1) * $limit;
        $totalUsers = $this->UsersModel->countAll();
        $totalPages = ceil($totalUsers / $limit);

        if (isset($_GET['tukhoa']) && !empty($_GET['tukhoa'])) {
            $tukhoa = $_GET['tukhoa'];
            $users = $this->UsersModel->timKiem($tukhoa);
        } else {

            $users = $this->UsersModel->all();

            $users = "";


            $users = $this->UsersModel->phantrang($offset, $limit);
        }

        $data = ['users' => $users];
        if (isset($tukhoa)) {
            $data['tukhoa'] = $tukhoa;
        
       
    }
        $this->view('users/index', 
        ['users' => $users , 
            'tukhoa' => $tukhoa,
            'totalPages' => $totalPages,
            'page' => $page]);
    }

    public function them()
    {

        $this->view('users/them', []);
    }

    public function luu()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ten = $_POST['ten'];
            $matkhau = $_POST['matkhau'];
            $role = "nguoidung";
            $mkmahoa = password_hash($matkhau, PASSWORD_DEFAULT);
            $nguoidung = $this->UsersModel->timnguoidung($ten);
            if ($nguoidung) {
                echo "Người dùng đã tồn tại";
            } else {

                $this->UsersModel->create(['ten' => $ten, 'matkhau' => $mkmahoa, 'role' => $role]);

                $this->redirect('http://localhost:8000/Auth/dangnhap');
            }
        }
    }

    public function edit($id)
    {
        $users = $this->UsersModel->find($id);
        // Sửa 'product' thành 'products'
        $this->view('users/edit', ['login' => $users]);
    }

    public function update_product($id)
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ten = $_POST['ten'];
            $matkhau = $_POST['matkhau'];
            $role = $_POST['role'];

            if (isset($_FILES['img']) && $_FILES['img']['error'] === 0) {
                $img =  $_FILES['img']['name'];
                $thumuc = "uploads/";
                $thumucluu = $thumuc . basename($img);
                move_uploaded_file($_FILES['img']['tmp_name'], $thumucluu);
            }
            $this->UsersModel->create(['ten' => $ten, 'matkhau' => $matkhau, 'role' => $role]);
            // Sửa đường dẫn redirect
            $this->redirect('http://localhost:8000/users/index');
        }
    }

    public function delete($id)
    {
        $users = $this->UsersModel->find($id);
        $this->UsersModel->delete($id);
        // Sửa đường dẫn redirect
        if ($users) {
            if (!empty($users['img'])) {
                $hinhanhxoa = 'uploads/' . $users['img'];
                if (file_exists($hinhanhxoa)) {
                    unlink($hinhanhxoa);
                }
            }
        }

        $this->redirect('http://localhost:8000/users/index');
    }
}
