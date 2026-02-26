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
    // Hàm lấy sản phẩm có lọc và phân trang
    public function getFilteredProducts($limit, $offset, $category_id = null, $min_price = null, $max_price = null)
    {
        $sql = "SELECT p.*, d.tendanhmuc, t.tenthuonghieu,
                       GROUP_CONCAT(DISTINCT bp.size ORDER BY bp.size ASC SEPARATOR ', ') as list_size,
                       GROUP_CONCAT(DISTINCT bp.color SEPARATOR ', ') as list_color
                FROM $this->table p
                LEFT JOIN danhmuc d ON p.danhmuc_id = d.id
                LEFT JOIN thuonghieu t ON p.thuonghieu_id = t.id
                LEFT JOIN bienthe_products bp ON p.id = bp.id_products
                WHERE 1=1";
        
        $params = [];

        // Lọc theo danh mục (loại)
        if (!empty($category_id)) {
            $sql .= " AND p.danhmuc_id = :category_id";
            $params['category_id'] = $category_id;
        }

        // Lọc theo giá tối thiểu
        if (!empty($min_price)) {
            $sql .= " AND p.price >= :min_price";
            $params['min_price'] = $min_price;
        }

        // Lọc theo giá tối đa
        if (!empty($max_price)) {
            $sql .= " AND p.price <= :max_price";
            $params['max_price'] = $max_price;
        }

        $sql .= " GROUP BY p.id LIMIT :limit OFFSET :offset";

        $conn = $this->connect();
        $stmt = $conn->prepare($sql);

        // Bind các tham số động
        foreach ($params as $key => &$val) {
            $stmt->bindParam(":$key", $val);
        }
        
        // Bind limit và offset (bắt buộc phải là kiểu INT)
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', (int)$offset, PDO::PARAM_INT);

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Hàm đếm tổng số sản phẩm để tính tổng số trang
    public function countFilteredProducts($category_id = null, $min_price = null, $max_price = null)
    {
        $sql = "SELECT COUNT(DISTINCT p.id) as total FROM $this->table p WHERE 1=1";
        $params = [];

        if (!empty($category_id)) {
            $sql .= " AND p.danhmuc_id = :category_id";
            $params['category_id'] = $category_id;
        }
        if (!empty($min_price)) {
            $sql .= " AND p.price >= :min_price";
            $params['min_price'] = $min_price;
        }
        if (!empty($max_price)) {
            $sql .= " AND p.price <= :max_price";
            $params['max_price'] = $max_price;
        }

        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute($params);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }
    // Thêm vào trong class ProductModel
    public function getRelatedProducts($danhmuc_id, $current_id, $limit = 4)
    {
        $sql = "SELECT p.*, d.tendanhmuc 
                FROM $this->table p 
                LEFT JOIN danhmuc d ON p.danhmuc_id = d.id 
                WHERE p.danhmuc_id = :danhmuc_id AND p.id != :current_id 
                LIMIT :limit";
        
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        
        $stmt->bindValue(':danhmuc_id', $danhmuc_id, PDO::PARAM_INT);
        $stmt->bindValue(':current_id', $current_id, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Thêm hoặc xóa sản phẩm yêu thích (Toggle)
    public function toggleYeuThich($user_id, $product_id)
    {
        $conn = $this->connect();
        
        // Kiểm tra xem đã yêu thích chưa
        $checkSql = "SELECT * FROM yeuthich WHERE user_id = :user_id AND product_id = :product_id";
        $stmtCheck = $conn->prepare($checkSql);
        $stmtCheck->execute(['user_id' => $user_id, 'product_id' => $product_id]);
        
        if ($stmtCheck->rowCount() > 0) {
            // Nếu có rồi thì XÓA (Bỏ yêu thích)
            $delSql = "DELETE FROM yeuthich WHERE user_id = :user_id AND product_id = :product_id";
            $stmtDel = $conn->prepare($delSql);
            $stmtDel->execute(['user_id' => $user_id, 'product_id' => $product_id]);
            return 'removed';
        } else {
            // Nếu chưa có thì THÊM (Yêu thích)
            $addSql = "INSERT INTO yeuthich (user_id, product_id) VALUES (:user_id, :product_id)";
            $stmtAdd = $conn->prepare($addSql);
            $stmtAdd->execute(['user_id' => $user_id, 'product_id' => $product_id]);
            return 'added';
        }
    }
    // Lấy danh sách sản phẩm yêu thích của 1 user
    public function getDanhSachYeuThich($user_id)
    {
        $sql = "SELECT p.*, d.tendanhmuc 
                FROM $this->table p
                INNER JOIN yeuthich y ON p.id = y.product_id
                LEFT JOIN danhmuc d ON p.danhmuc_id = d.id
                WHERE y.user_id = :user_id
                ORDER BY y.created_at DESC";
                
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        $stmt->execute(['user_id' => $user_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    // Lấy danh sách sản phẩm theo mảng ID (Dành cho chức năng Đã xem gần đây)
    public function getProductsByIds($ids)
    {
        if (empty($ids)) return [];

        // Tạo ra chuỗi các dấu chấm hỏi (?, ?, ?) tương ứng với số lượng ID
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        
        $sql = "SELECT p.*, d.tendanhmuc 
                FROM $this->table p
                LEFT JOIN danhmuc d ON p.danhmuc_id = d.id
                WHERE p.id IN ($placeholders)";
        
        $conn = $this->connect();
        $stmt = $conn->prepare($sql);
        // Truyền mảng ids vào execute để bind giá trị an toàn
        $stmt->execute($ids);
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Sắp xếp lại kết quả theo đúng thứ tự của mảng $ids (từ mới nhất -> cũ nhất)
        $sorted_products = [];
        foreach ($ids as $id) {
            foreach ($products as $p) {
                if ($p['id'] == $id) {
                    $sorted_products[] = $p;
                    break;
                }
            }
        }
        return $sorted_products;
    }
}
?>