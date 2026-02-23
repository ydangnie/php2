<?php

class AdminController extends Controller
{
    private $productModel;
    private $userModel;
    // private $orderModel; // Nếu có

    public function __construct()
    {
        // Gọi các model cần thiết để đếm số liệu
        $this->productModel = $this->model('ProductModel');
        $this->userModel = $this->model('UsersModel');
    }

    public function dashboard()
    {
        // 1. Lấy số lượng thống kê
        $countProducts = $this->productModel->countAll(); // Hàm này bạn đã có trong ProductModel
        $countUsers = 10; // Ví dụ, bạn cần viết thêm hàm countAll() trong UsersModel
        $countOrders = 5; // Ví dụ giả định

        $recentProducts = $this->productModel->phantrang(0, 5); 

        // 3. Truyền data ra View
        $this->view('admin/dashboard', [
            'countProducts' => $countProducts,
            'countUsers' => $countUsers,
            'countOrders' => $countOrders,
            'recentProducts' => $recentProducts
        ]);
    }
}