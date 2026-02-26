<link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    /* CSS Độc nhất cho Nav - Không ảnh hưởng trang khác */
    #unique-master-header {
        font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
        background: rgba(255, 255, 255, 0.98);
        /* Màu trắng đục nhẹ */
        backdrop-filter: blur(10px);
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.03);
        z-index: 9999;
        /* Quan trọng: Đảm bảo menu nằm trên Hero Banner */
        position: sticky;
        /* Dính menu khi cuộn */
        top: 0;
    }

    /* Hiệu ứng Logo */
    #unique-master-header .navbar-brand img {
        transition: transform 0.3s;
        max-height: 50px;
        /* Giới hạn chiều cao logo để không vỡ khung */
        width: auto;
    }

    #unique-master-header .navbar-brand:hover img {
        transform: scale(1.05);
    }

    /* Link menu */
    #unique-master-header .umh-link {
        color: #2c3e50;
        font-weight: 600;
        font-size: 0.95rem;
        padding: 8px 16px !important;
        text-transform: uppercase;
        position: relative;
        transition: color 0.3s;
    }

    /* Hiệu ứng gạch chân hover */
    #unique-master-header .umh-link::after {
        content: '';
        position: absolute;
        width: 0;
        height: 2px;
        bottom: 0;
        left: 50%;
        background-color: #000;
        transition: all 0.3s;
        transform: translateX(-50%);
    }

    #unique-master-header .umh-link:hover::after {
        width: 80%;
    }

    #unique-master-header .umh-link:hover {
        color: #000;
    }

    /* Dropdown */
    #unique-master-header .dropdown-menu {
        border: none;
        border-radius: 12px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        margin-top: 10px;
        padding: 10px;
    }

    #unique-master-header .dropdown-item {
        border-radius: 8px;
        padding: 8px 15px;
        font-weight: 500;
    }

    #unique-master-header .dropdown-item:hover {
        background-color: #f8f9fa;
        transform: translateX(5px);
        transition: transform 0.2s;
    }

    /* Form tìm kiếm tròn */
    .umh-search-group {
        border: 1px solid #e1e1e1;
        border-radius: 50px;
        padding: 3px 5px;
        background: #fff;
        overflow: hidden;
    }

    .umh-search-input {
        border: none;
        box-shadow: none !important;
        background: transparent;
        font-size: 0.9rem;
    }

    .umh-search-btn {
        border: none;
        background: #000;
        color: #fff;
        border-radius: 50%;
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .umh-search-btn:hover {
        background: #333;
    }

    /* Icon User/Cart */
    .umh-icon-action {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #f8f9fa;
        color: #333;
        position: relative;
        transition: all 0.3s;
    }

    .umh-icon-action:hover {
        background: #000;
        color: #fff;
    }
</style>

<nav id="unique-master-header" class="navbar navbar-expand-lg">
    <div class="container">
        <a class="navbar-brand" href="/view/index">
            <img src="https://theme.hstatic.net/1000306633/1001194548/14/logo.png?v=491" alt="Logo">
        </a>

        <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse"
            data-bs-target="#uniqueNavbarCollapse">
            <i class="fas fa-bars"></i>
        </button>

        <div id="uniqueNavbarCollapse" class="collapse navbar-collapse">
            <ul class="navbar-nav mx-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link umh-link active" href="/view/index">Trang chủ</a></li>
                <li class="nav-item"><a class="nav-link umh-link active" href="/view/sanpham">Sản phẩm</a></li>
                <?php 
             $user = $_SESSION['user'] ?? null;
$role = 'nguoidung';
if ($user) {
    $role = is_array($user) ? $user['role'] : ($user->role ?? 'nguoidung');
}
                ?>

                <?php if ($role == 'admin'): ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle umh-link" href="#" role="button" data-bs-toggle="dropdown">Quản
                        Lý</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="/products/index"><i
                                    class="fas fa-box me-2 text-muted"></i>Sản phẩm</a></li>
                        <li><a class="dropdown-item" href="/danhmuc/index"><i
                                    class="fas fa-list me-2 text-muted"></i>Danh mục</a></li>
                        <li><a class="dropdown-item" href="/thuonghieu/index"><i
                                    class="fas fa-tag me-2 text-muted"></i>Thương hiệu</a></li>
                        <li><a class="dropdown-item" href="/tintuc/index"><i
                                    class="fas fa-newspaper me-2 text-muted"></i>Tin tức</a></li>
                        <li><a class="dropdown-item" href="/users/index"><i
                                    class="fas fa-users me-2 text-muted"></i>Người dùng</a></li>
                        <li><a class="dropdown-item" href="/magiamgia/index"><i
                                    class="fas fa-ticket-alt me-2 text-muted"></i>Mã giảm giá</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/contacts/index"><i
                                    class="fas fa-envelope me-2 text-muted"></i>Liên hệ</a>
                        </li>
                    </ul>
                </li>
                <?php endif; ?>
            </ul>

            <div class="d-flex align-items-center gap-3 mt-3 mt-lg-0">
                <form action="/view/timkiem" method="GET" class="d-flex">
                    <input class="form-control rounded-0 border-dark me-2" type="search" name="keyword"
                        placeholder="Nhập tên sản phẩm..." required>
                    <button class="btn btn-dark rounded-0" type="submit"><i class="fas fa-search"></i></button>
                </form>

                <a href="view/cart" class="umh-icon-action text-decoration-none" title="Giỏ hàng">
                    <i class="fas fa-shopping-bag"></i>
                    <span
                        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light"
                        style="font-size: 0.6rem;">0</span>
                </a>
                <a href="/view/yeuthich" class="text-dark me-3 position-relative" title="Yêu thích">
                    <i class="fas fa-heart fs-5"></i>
                </a>

                <?php if(isset($_SESSION['user'])): ?>
                                <div class="dropdown">
                                    <a class="text-dark text-decoration-none dropdown-toggle d-flex align-items-center gap-2 fw-bold"
                                        href="#" role="button" data-bs-toggle="dropdown">
                                        <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center"
                                            style="width: 32px; height: 32px;">
                                            <?php 
                                                                                    $ten = is_array($_SESSION['user']) ? $_SESSION['user']['ten'] : $_SESSION['user']->ten;
                    echo strtoupper(substr($ten ?? 'M', 0, 1));
                                                                                ?>
                                        </div>
                                        <span class="d-none d-md-block">
                                            <?php    echo is_array($_SESSION['user']) ? $_SESSION['user']['ten'] : $_SESSION['user']->ten; ?>
                                        </span>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end mt-2">
                                        <li><a class="dropdown-item" href="/profile">Hồ sơ</a></li>
                                        <li><a class="dropdown-item" href="/orders">Đơn hàng</a></li>
                                        <li><a href="/view/daxem" class="dropdown-item" title="Đã xem gần đây">
                                               Đã xem gần đây
                                            </a>
                                        </li>
                                        <li>
                                            <hr class="dropdown-divider">
                                        </li>
                                        <li><a class="dropdown-item text-danger" href="/auth/logout">Đăng xuất</a></li>
                                    </ul>
                                </div>
                <?php else: ?>
                    <a href="/auth/login" class="btn btn-dark rounded-pill px-4 fw-bold shadow-sm"
                        style="font-size: 0.85rem;">Login</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script><?php /**PATH C:\xampp\htdocs\all_php\php11\app\views/layout/nav.blade.php ENDPATH**/ ?>