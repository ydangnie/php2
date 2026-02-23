<?php
class ProductModel extends Model
{
    private $table = "products";
    private $table_bienthe = "bienthe_products";

    public function all()
    {
        $sql = "SELECT * FROM $this->table p LEFT JOIN danhmuc d ON p.danhmuc_id = d.id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id)
    {
        $sql = "SELECT *  FROM $this->table  WHERE id = :id";
         
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $sql = "INSERT INTO $this->table (name, price, mota, img, danhmuc_id, thuonghieu_id, soluong) VALUES (:name, :price, :mota, :img, :danhmuc_id, :thuonghieu_id, :soluong)";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([
            'name' => $data['name'],
            'price' => $data['price'],
            'mota' => $data['mota'],
            'img' => $data['img'],
            'danhmuc_id' => $data['danhmuc_id'],
            'thuonghieu_id' => $data['thuonghieu_id'],
            'soluong' => $data['soluong']
        ]);
        if ($result) {
            return $conn->lastInsertId();
        }
        return false;
    }

    public function update($data, $id)
    {
        $sql = "UPDATE $this->table SET name = :name, price = :price, mota = :mota, img = :img, 
        danhmuc_id = :danhmuc_id, thuonghieu_id = :thuonghieu_id , soluong  = :soluong WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            'name' => $data['name'],
            'price' => $data['price'],
            'mota' => $data['mota'],
            'img' => $data['img'],
            'danhmuc_id' => $data['danhmuc_id'],
            'thuonghieu_id' => $data['thuonghieu_id'],
            'soluong' => $data['soluong'],
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
     
        $sql = "SELECT p.*, d.tendanhmuc, t.tenthuonghieu,
                       GROUP_CONCAT(DISTINCT bp.size SEPARATOR ', ') as list_size,
                       GROUP_CONCAT(DISTINCT bp.color SEPARATOR ', ') as list_color
                FROM $this->table p
                LEFT JOIN danhmuc d ON p.danhmuc_id = d.id
                LEFT JOIN thuonghieu t ON p.thuonghieu_id = t.id
                LEFT JOIN bienthe_products bp ON p.id = bp.id_products
                WHERE p.name LIKE :tukhoa
                GROUP BY p.id"; // Group by để gộp dòng

        $conn = $this->connect();
        $stmt = $conn->prepare($sql);

        $search = "%" . $tukhoa . "%";
        $stmt->execute(['tukhoa' => $search]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function countAll()
    {
        $sql = "SELECT COUNT(*) as total FROM $this->table";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    // SỬA HÀM PHÂN TRANG ĐỂ HIỂN THỊ SIZE
    public function phantrang($offset, $limit)
    {
        // Thêm JOIN bảng bienthe_products và GROUP_CONCAT
        $sql = "SELECT p.*, d.tendanhmuc, t.tenthuonghieu,
                       GROUP_CONCAT(DISTINCT bp.size ORDER BY bp.size ASC SEPARATOR ', ') as list_size,
                       GROUP_CONCAT(DISTINCT bp.color SEPARATOR ', ') as list_color
                FROM products p
                LEFT JOIN danhmuc d ON p.danhmuc_id = d.id
                LEFT JOIN thuonghieu t ON p.thuonghieu_id = t.id
                LEFT JOIN bienthe_products bp ON p.id = bp.id_products
                GROUP BY p.id
                LIMIT :limit OFFSET :offset";
                
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Các hàm biến thể giữ nguyên
    public function getBienthe($id_products) {
        $sql = "SELECT * FROM $this->table_bienthe WHERE id_products = :id_products";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id_products' => $id_products]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addBienthe($data) {
        $sql = "INSERT INTO $this->table_bienthe (id_products, size, color, img, soluong) VALUES (:id_products, :size, :color, :img, :soluong)";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute($data);
    }

    public function deleteBienthe($id) {
        $sql = "DELETE FROM $this->table_bienthe WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
?>