<?php
// Class name phải khớp với tên file để autoload hoạt động
class SinhVienModel extends Model {
    private $table = "sinhvien";

    public function all() {
        $sql = "SELECT * FROM $this->table";
        $conn = $this->connect(); // Sử dụng hàm connect từ class cha Model
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $sql = "SELECT * FROM $this->table WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $sql = "INSERT INTO $this->table (mssv, hotensv,  nganh) VALUES (:mssv, :hotensv, :nganh)";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            'mssv' => $data['mssv'],
            'hotensv' => $data['hotensv'],
             'nganh' => $data['nganh']

        ]);
    }

    public function update($data, $id) {
        $sql = "UPDATE $this->table SET mssv = :mssv, hotensv = :hotensv, nganh = :nganh WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            'mssv' => $data['mssv'],
            'hotensv' => $data['hotensv'],
             'nganh' => $data['nganh'],
             'id' => $id
        ]);
    }

    public function delete($id) {
        $sql = "DELETE FROM $this->table WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}