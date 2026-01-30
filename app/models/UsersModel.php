<?php
// Class name phải khớp với tên file để autoload hoạt động
class UsersModel extends Model
{
    private $table = "login";

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
        $sql = "INSERT INTO $this->table (ten, matkhau, role) VALUES (:ten, :matkhau, :role)";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            'ten' => $data['ten'],
            'matkhau' => $data['matkhau'],
            'role' => $data['role']

        ]);
    }

    public function update($data, $id)
    {
        $sql = "UPDATE $this->table SET ten = :ten, matkhau = :matkhau, role = :role WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            'ten' => $data['ten'],
            'matkhau' => $data['matkhau'],
            'role' => $data['role'],
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
