<?php
// Class name phải khớp với tên file để autoload hoạt động
class AuthModel extends Model {
    private $table = "users";

    public function all() {
        $sql = "SELECT * FROM $this->table";
        $conn = $this->connect(); // Sử dụng hàm connect từ class cha Model
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function timnguoidung($email){
         $sql = "SELECT * FROM $this->table WHERE email = :email";
           $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function find($id) {
        $sql = "SELECT * FROM $this->table WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $sql = "INSERT INTO $this->table (email, ten, matkhau) VALUES (:email, :ten, :matkhau)";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            'email' => $data['email'],
            'ten' => $data['ten'],
            'matkhau' => $data['matkhau']
        ]);
    }

    public function update($data, $id) {
        $sql = "UPDATE $this->table SET email = :email, ten = :ten, matkhau = :matkhau WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            'email' => $data['email'],
            'ten' => $data['ten'],
            'matkhau' => $data['matkhau'],
            'id' => $id
        ]);
    }

    public function delete($id) {
        $sql = "DELETE FROM $this->table WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
    public function role($role){
    $sql = "SELECT * FROM $this->table WHERE role = :role";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute(['role' => $role]);
    }
   
}