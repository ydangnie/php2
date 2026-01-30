<h2>Đăng nhập</h2>
<?php if(isset($_SESSION['thongbao'])): ?>
<div style="
        background-color: #d4edda; 
        color: #155724; 
        padding: 10px; 
        margin-bottom: 20px; 
        border: 1px solid #c3e6cb; 
        border-radius: 5px;">
        
        <?= $_SESSION['thongbao']; ?>
        
    </div>

<?php unset($_SESSION['thongbao'])?>
<?php endif; ?>
<form action="/Auth/ktra" method="POST">
    <label>Tên đăng nhập:</label>
    <input type="text" name="ten" required><br>
    <label>Mật khẩu</label>
    <input type="password" name="matkhau" required><br>
    <button type="submit">Đăng nhập</button>
</form>