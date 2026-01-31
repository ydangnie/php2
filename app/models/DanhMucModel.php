<?php
// Class name phải khớp với tên file để autoload hoạt động
class DanhMucModel extends Model
{
    private $table = "danhmuc";

    public function all()
    {
        $sql = "SELECT * FROM $this->table";
        $conn = $this->connect(); 
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
        $sql = "INSERT INTO $this->table (tendanhmuc, img) VALUES (:tendanhmuc, :img)";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            'tendanhmuc' => $data['tendanhmuc'],
            'img' => $data['img']
        ]);
    }

    public function update($data, $id)
    {
        $sql = "UPDATE $this->table SET tendanhmuc = :tendanhmuc, img = :img WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            'tendanhmuc' => $data['tendanhmuc'],
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
public function countAll() {
    $sql = "SELECT COUNT(*) as total FROM $this->table";
    $conn = $this->connect();
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
    return $row['total'];
}

public function phantrang($offset, $limit) {
    $sql = "SELECT * FROM $this->table LIMIT :limit OFFSET :offset";
    $conn = $this->connect();
    $stmt = $conn->prepare($sql);
    // Bind số nguyên để tránh lỗi LIMIT trong PDO
    $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
    $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

public function timKiem($tukhoa) {
    $sql = "SELECT * FROM $this->table WHERE tendanhmuc LIKE :tukhoa";
    $conn = $this->connect();
    $stmt = $conn->prepare($sql);
    $stmt->execute(['tukhoa' => "%$tukhoa%"]);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
  
}
