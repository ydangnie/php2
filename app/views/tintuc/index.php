<h2>Danh sách sản phẩm</h2>
<a href="/tintuc/them">Thêm sản phẩm mới</a>

<?php if (isset($_SESSION['thongbao'])): ?>
    <div style="
        background-color: #d4edda; 
        color: #155724; 
        padding: 10px; 
        margin-bottom: 20px; 
        border: 1px solid #c3e6cb; 
        border-radius: 5px;">

        <?= $_SESSION['thongbao']; ?>

    </div>

    <?php unset($_SESSION['thongbao']) ?>
<?php endif; ?>


<form action="/tintuc/index" method="GET" style="margin-bottom: 20px;">
    <input type="text" name="tukhoa"
        placeholder="Nhập Tên sản phẩm"
        style="padding: 5px; width: 300px;">
    <button type="submit" style="padding: 5px 10px;">Tìm kiếm</button>
</form>

<table border="1">
    <tr>
        <th>Tiêu đề</th>
        <th>Mô tả</th>

        <th>Hành động</th>
    </tr>
    <?php if (empty($tintuc)): ?>
        <tr>
            <td colspan="5" style="text-align: center; color: red;">Không tìm thấy kết quả nào phù hợp!</td>
        </tr>
    <?php else: ?>
        <?php foreach ($tintuc as $tt): ?>
            <tr>
                <td><?= $tt['tieude'] ?></td>
              
                <td><?= $tt['mota'] ?></td>
                <td>
                    <a href="/tintuc/edit/<?= $tt['id'] ?>">Sửa</a> |
                    <a href="/tintuc/delete/<?= $tt['id'] ?>" onclick="return confirm('Xóa hả?')">Xóa</a>
                </td>
            </tr>

        <?php endforeach; ?>
    <?php endif; ?>
</table>
<table border="1">
</table>

<div style="margin-top: 20px;">
    <strong>Trang: </strong>
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="/products/index?page=<?= $i ?>"
            style="padding: 5px 10px; border: 1px solid #ccc; margin-right: 5px; text-decoration: none; 
                  <?= ($i == $page) ? 'background-color: #007bff; color: white;' : '' ?>">
            <?= $i ?>
        </a>
    <?php endfor; ?>
</div>