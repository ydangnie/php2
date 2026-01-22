<h2>Danh sách danh mục</h2>
<a href="/danhmuc/them">Thêm danh mục</a>
<table border="1">
    <tr>
        <th>ID</th>
        <th>Tên danh mục</th>
        <th>Ảnh</th>
    </tr>
    <?php foreach ($danhmuc as $dm): ?>
    <tr>
        <td><?= $dm['id'] ?></td>
        <td><?= $dm['tendanhmuc'] ?></td>
         <td> <img src="/uploads/<?= $dm['img'] ?>" alt="" width="50px"></td>
        <td>
            <a>Sửa</a> | 
            <a>Xóa</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>