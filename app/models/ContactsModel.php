<?php
class ContactsModel extends Model
{
    private $table = "contacts";


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
        $sql = "SELECT *  FROM $this->table  WHERE id = :id";

        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data)
    {
        $sql = "INSERT INTO $this->table (full_name, email, phone, subject, message) VALUES (:full_name, :email, :phone, :subject, :message)";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $result = $stmt->execute([
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'subject' => $data['subject'],
            'message' => $data['message']

        ]);
        if ($result) {
            return $conn->lastInsertId();
        }
        return false;
    }

    public function update($data, $id)
    {
        $sql = "UPDATE $this->table SET full_name = :full_name, email = :email, phone = :phone, subject = :subject, message = :message WHERE id = :id";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        return $stmt->execute([
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'subject' => $data['subject'],
            'message' => $data['message'],
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
        $sql = "SELECT * FROM $this->table WHERE contacts LIKE :tukhoa";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute(['tukhoa' => "%$tukhoa%"]);
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


    public function phantrang($offset, $limit)
    {
        $sql = "SELECT * FROM $this->table LIMIT :limit OFFSET :offset";
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
