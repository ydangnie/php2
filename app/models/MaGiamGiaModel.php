<?php

class MaGiamGiaModel extends Model {
    // Khai báo tên bảng trong Database
    protected $table = 'ma_giam_gia';

    // 1. Lấy danh sách tất cả mã (để hiển thị ra bảng)
    public function layDanhSach() {
        // Sắp xếp ID giảm dần (mới nhất lên đầu)
        $sql = "SELECT * FROM $this->table ORDER BY id DESC";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 2. Lấy thông tin 1 mã (để sửa)
    public function layChiTiet($id) {
        $sql = "SELECT * FROM $this->table WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 3. Thêm mã mới vào Database
    public function themMoi($dulieu) {
        $sql = "INSERT INTO $this->table (ma_code, loai, gia_tri, so_luong, ngay_het_han, trang_thai) 
                VALUES (:ma_code, :loai, :gia_tri, :so_luong, :ngay_het_han, :trang_thai)";
        
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute($dulieu);
    }

    // 4. Cập nhật mã đã có
    public function capNhat($id, $dulieu) {
        $sql = "UPDATE $this->table 
                SET ma_code = :ma_code, loai = :loai, gia_tri = :gia_tri, 
                    so_luong = :so_luong, ngay_het_han = :ngay_het_han, trang_thai = :trang_thai 
                WHERE id = :id";
        
        // Thêm ID vào mảng dữ liệu để khớp với :id ở trên
        $dulieu['id'] = $id; 
        
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute($dulieu);
    }

    // 5. Xóa mã
    public function xoa($id) {
        $sql = "DELETE FROM $this->table WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
    
    // 6. Kiểm tra xem mã nhập vào có bị trùng không
    public function kiemTraTrungMa($ma_code) {
        $sql = "SELECT id FROM $this->table WHERE ma_code = :ma_code";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute(['ma_code' => $ma_code]);
        return $stmt->fetch(); // Nếu có dữ liệu trả về nghĩa là trùng
    }
    // Thêm vào trong class MaGiamGiaModel
public function timTheoMa($code) {
    // Tìm mã code, phải còn hạn sử dụng và đang bật (trang_thai = 1)
    $sql = "SELECT * FROM $this->table 
            WHERE ma_code = :ma_code 
            AND trang_thai = 1 
            AND ngay_het_han >= CURDATE()"; // CURDATE() là ngày hiện tại
            
    $conn = $this->connect();
    $stmt = $conn->prepare($sql);
    $stmt->execute(['ma_code' => $code]);
    return $stmt->fetch(PDO::FETCH_ASSOC);
}
}