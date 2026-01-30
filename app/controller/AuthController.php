<?php

use Illuminate\View\View;

class AuthController extends Controller
{
    private $authmodel;

    public function __construct()
    {
        $this->authmodel = $this->model('AuthModel');
    }

    public function dangky()
    {

        $this->view('Auth/dangky', []);
    }

    public function luu()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ten = $_POST['ten'];
            $matkhau = $_POST['matkhau'];
            $role = "nguoidung";
            $mkmahoa = password_hash($matkhau, PASSWORD_DEFAULT);
            $nguoidung = $this->authmodel->timnguoidung($ten);
            if ($nguoidung) {
                echo "Người dùng đã tồn tại";
            } else {

                $this->authmodel->create(['ten' => $ten, 'matkhau' => $mkmahoa, 'role' => $role]);

                $this->redirect('http://localhost:8000/Auth/dangnhap');
            }
        }
    }
    public function dangnhap()
    {
        $this->view('Auth/dangnhap', []);
    }
    public function ktra()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ten = $_POST['ten'];
            $matkhau = $_POST['matkhau'];
            $nguoidung = $this->authmodel->timnguoidung($ten);
         
            if ($nguoidung && password_verify($matkhau, $nguoidung['matkhau'])) {
               
                $_SESSION['login']= [
                    'id' => $nguoidung['id'],
                    'ten' => $nguoidung['ten'],
                    'role' => $nguoidung['nguoidung']


                ];
                if($nguoidung['role'] === 'admin' ){
                   
                    echo "Đăng nhập thành công";
                $this->redirect('http://localhost:8000/products/trangchu'); 
                }else{
                    $this->redirect('http://localhost:8000/home/trangchu'); 
                }


            } else {
                echo "Đăng nhập thất bại";
            }
        }
    }
}
