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
    public function nhapmk($email, $matkhaumoi)
    {
       $sql = "UPDATE $this->table SET matkhau = :matkhau WHERE email = :email";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
           'email' => $email,
        'matkhau' => $matkhaumoi
         
        ]);
    }
    public function checkGoogleUser($email) {
        // Tìm user theo email
        $sql = "SELECT * FROM $this->table WHERE email = :email";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    // 2. Tạo user mới nếu họ lần đầu đăng nhập bằng Google
    public function createGoogleUser($email, $name, $google_id) {
        // Lưu ý: Password để trống hoặc random chuỗi vì họ dùng GG để login
        // Role mặc định là 'nguoidung' (hoặc 0 tùy quy ước DB của bạn)
        $sql = "INSERT INTO $this->table (ten, email, google_id, role, matkhau) VALUES (:ten, :email, :google_id, :role, :matkhau)";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            'ten' => $name,
            'email' => $email,
            'google_id' => $google_id,
            'role' => 'nguoidung', 
            'matkhau' => '' // Không cần mật khẩu
        ]);
    }
   
}