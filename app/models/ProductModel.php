<?php
// Class name phải khớp với tên file để autoload hoạt động
class ProductModel extends Model
{
    private $table = "products";

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
        $sql = "INSERT INTO $this->table (name, price, mota, img, danhmuc_id, thuonghieu_id) VALUES (:name, :price, :mota, :img, :danhmuc_id, :thuonghieu_id)";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            'name' => $data['name'],
            'price' => $data['price'],
            'mota' => $data['mota'],
            'img' => $data['img'],
            'danhmuc_id' => $data['danhmuc_id'],
            'thuonghieu_id' => $data['thuonghieu_id']
        ]);
    }

    public function update($data, $id)
    {
        $sql = "UPDATE $this->table SET name = :name, price = :price, mota = :mota, img = :img WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            'name' => $data['name'],
            'price' => $data['price'],
            'mota' => $data['mota'],
            'img' => $data['img'],
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
    public function timKiem($tukhoa)
    {
        $sql = "SELECT * FROM $this->table WHERE name LIKE :tukhoa";
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

    public function phantrang($offset, $limit)
    {

        $sql = "SELECT p.*, d.tendanhmuc, t.tenthuonghieu 
            FROM products p
            LEFT JOIN danhmuc d ON p.danhmuc_id = d.id
            LEFT JOIN thuonghieu t ON p.thuonghieu_id = t.id
            LIMIT :limit OFFSET :offset";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
