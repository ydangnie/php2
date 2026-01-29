<?php
// Class name phải khớp với tên file để autoload hoạt động
class ThuongHieuModel extends Model
{
    private $table = "thuonghieu";

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
        $sql = "INSERT INTO $this->table (tenthuonghieu, img) VALUES (:tenthuonghieu, :img)";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            'tenthuonghieu' => $data['tenthuonghieu'],
            'img' => $data['img']
        ]);
    }

    public function update($data, $id)
    {
        $sql = "UPDATE $this->table SET tenthuonghieu = :tenthuonghieu, img = :img WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            'tenthuonghieu' => $data['tenthuonghieu'],
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
  
}
