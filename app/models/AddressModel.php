<?php
class AddressModel extends Model {
    protected $table = 'user_addresses';

    public function getByUserId($user_id) {
        $sql = "SELECT * FROM {$this->table} WHERE user_id = :user_id ORDER BY is_default DESC, id DESC";
        $stmt = $this->connect()->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addAddress($data) {
        $conn = $this->connect();
        
        // Nếu user tick chọn "Đặt làm mặc định", ta sẽ gỡ mặc định các địa chỉ cũ
        if (isset($data['is_default']) && $data['is_default'] == 1) {
            $resetSql = "UPDATE {$this->table} SET is_default = 0 WHERE user_id = :user_id";
            $conn->prepare($resetSql)->execute(['user_id' => $data['user_id']]);
        }

        $sql = "INSERT INTO {$this->table} (user_id, ten_nguoi_nhan, sdt, dia_chi, is_default) 
                VALUES (:user_id, :ten, :sdt, :diachi, :is_default)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            'user_id' => $data['user_id'],
            'ten' => $data['ten_nguoi_nhan'],
            'sdt' => $data['sdt'],
            'diachi' => $data['dia_chi'],
            'is_default' => $data['is_default'] ?? 0
        ]);
    }
}
?>