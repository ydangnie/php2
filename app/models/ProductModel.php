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
        $sql = "INSERT INTO $this->table (name, price, mota, img) VALUES (:name, :price, :mota, :img)";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            'name' => $data['name'],
            'price' => $data['price'],
            'mota' => $data['mota'],
            'img' => $data['img']
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
       public function timkiem($tukhoa){
        $sql = "SELECT * FROM $this->table WHERE name LIKE :tukhoa ";
        $conn =$this->connect();
        $stmt = $conn->prepare($sql);

        $search = "%". $tukhoa ."%";
        $stmt->execute(['tukhoa' => $search]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);

    }
  
}
