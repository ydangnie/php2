<?php
class CouponModel extends Model {
    private $table = "coupons";
    // ... Copy các hàm all(), find(), create()... từ ProductModel sang và sửa tên bảng
    
    public function findByCode($code) {
        $sql = "SELECT * FROM $this->table WHERE code = :code";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute(['code' => $code]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}