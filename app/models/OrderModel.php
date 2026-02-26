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
}
?>