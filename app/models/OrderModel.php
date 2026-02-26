<?php
class OrderModel extends Model {
    public function taoDonHang($data, $cart) {
        $conn = $this->connect();
        
        // 1. Thêm vào bảng donhang
        $sql = "INSERT INTO donhang (user_id, ten_nguoi_nhan, sdt, dia_chi, ghi_chu, tong_tien, phuong_thuc_tt, trang_thai_tt) 
                VALUES (:user_id, :ten, :sdt, :diachi, :ghichu, :tongtien, :pttt, :tttt)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([
            'user_id' => $data['user_id'],
            'ten' => $data['ten_nguoi_nhan'],
            'sdt' => $data['sdt'],
            'diachi' => $data['dia_chi'],
            'ghichu' => $data['ghi_chu'],
            'tongtien' => $data['tong_tien'],
            'pttt' => $data['phuong_thuc_tt'],
            'tttt' => $data['trang_thai_tt']
        ]);
        
        $donhang_id = $conn->lastInsertId();

        // 2. Thêm vào bảng chitiet_donhang
        $sqlDetail = "INSERT INTO chitiet_donhang (donhang_id, product_id, size, color, so_luong, gia) 
                      VALUES (:dh_id, :sp_id, :size, :color, :sl, :gia)";
        $stmtDetail = $conn->prepare($sqlDetail);
        
        foreach ($cart as $item) {
            $stmtDetail->execute([
                'dh_id' => $donhang_id,
                'sp_id' => $item['id'],
                'size' => $item['size'],
                'color' => $item['color'],
                'sl' => $item['quantity'],
                'gia' => $item['price']
            ]);
        }
        return $donhang_id;
    }

    public function updateTrangThaiThanhToan($donhang_id, $trang_thai) {
        $sql = "UPDATE donhang SET trang_thai_tt = :tt WHERE id = :id";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute(['tt' => $trang_thai, 'id' => $donhang_id]);
    }
    // --- CÁC HÀM MỚI THÊM VÀO ---

    // 1. Lấy tất cả đơn hàng (Dành cho Admin)
    public function getAllOrders() {
        $sql = "SELECT * FROM donhang ORDER BY created_at DESC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2. Lấy đơn hàng theo ID User (Dành cho Khách hàng xem lịch sử)
    public function getOrdersByUserId($user_id) {
        $sql = "SELECT * FROM donhang WHERE user_id = :user_id ORDER BY created_at DESC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 3. Lấy thông tin 1 đơn hàng cụ thể
    public function getOrderById($id) {
        $sql = "SELECT * FROM donhang WHERE id = :id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 4. Lấy danh sách sản phẩm trong 1 đơn hàng (Chi tiết đơn hàng)
    public function getOrderDetails($donhang_id) {
        $sql = "SELECT c.*, p.name, p.img 
                FROM chitiet_donhang c 
                JOIN products p ON c.product_id = p.id 
                WHERE c.donhang_id = :donhang_id";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['donhang_id' => $donhang_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 5. Cập nhật trạng thái đơn hàng (Dành cho Admin)
    public function updateTrangThaiDon($id, $trang_thai_don, $trang_thai_tt) {
        $sql = "UPDATE donhang SET trang_thai_don = :tt_don, trang_thai_tt = :tt_tt WHERE id = :id";
        $stmt = $this->connect()->prepare($sql);
        return $stmt->execute([
            'tt_don' => $trang_thai_don,
            'tt_tt' => $trang_thai_tt,
            'id' => $id
        ]);
    }
    // Hủy đơn hàng bởi người dùng (Chỉ khi đang chờ xác nhận)
    public function huyDonHangUser($donhang_id, $user_id) {
        $sql = "UPDATE donhang SET trang_thai_don = 'da_huy' 
                WHERE id = :id AND user_id = :user_id AND trang_thai_don = 'cho_xac_nhan'";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['id' => $donhang_id, 'user_id' => $user_id]);
        
        // Trả về true nếu có dòng được cập nhật thành công
        return $stmt->rowCount() > 0; 
    }
}
?>