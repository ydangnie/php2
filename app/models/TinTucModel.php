<?php
// Class name phải khớp với tên file để autoload hoạt động
class TinTucModel extends Model
{
    private $table = "tintuc";

    public function all()
    {
        $sql = "SELECT * FROM $this->table";
        $conn = $this->connect(); // Sử dụng hàm connect từ class cha Model
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $sql = "SELECT * FROM $this->table WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $sql = "INSERT INTO $this->table (tieude, mota) VALUES (:tieude, :mota)";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            'tieude' => $data['tieude'],

            'mota' => $data['mota']

        ]);
    }

    public function update($data, $id)
    {
        $sql = "UPDATE $this->table SET tieude = :tieude, mota = :mota WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            'tieude' => $data['tieude'],

            'mota' => $data['mota'],

            'id' => $id
        ]);
    }

    public function delete($id)
    {
        $sql = "DELETE FROM $this->table WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
    public function timkiem($tukhoa)
    {
        $sql = "SELECT * FROM $this->table WHERE name LIKE :tukhoa ";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);

        $search = "%" . $tukhoa . "%";
        $stmt->execute(['tukhoa' => $search]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // 1. Hàm đếm tổng số sản phẩm
    public function countAll()
    {
        $sql = "SELECT COUNT(*) as total FROM $this->table";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    // 2. Hàm lấy sản phẩm có phân trang
    public function paginate($offset, $limit)
    {
        // Lưu ý: Dùng bindValue với PDO::PARAM_INT để tránh lỗi SQL với Limit
        $sql = "SELECT * FROM $this->table LIMIT :limit OFFSET :offset";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
