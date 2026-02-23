<div class="d-flex flex-column flex-shrink-0 p-3 text-white bg-dark" style="width: 260px; height: 100vh; position: fixed; top: 0; left: 0; z-index: 1000;">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto text-white text-decoration-none">
        <i class="fas fa-bolt fa-2x me-2 text-warning"></i>
        <span class="fs-4 fw-bold">Admin Panel</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="/admin/dashboard" class="nav-link text-white {{ strpos($_SERVER['REQUEST_URI'], 'dashboard') !== false ? 'active bg-primary' : '' }}">
                <i class="fas fa-home me-2" style="width: 20px;"></i>
                Dashboard
            </a>
        </li>
        <li class="nav-item mt-2">
            <small class="text-white-50 text-uppercase fw-bold ps-3" style="font-size: 12px;">Quản lý</small>
        </li>
        <li>
            <a href="/products/index" class="nav-link text-white {{ strpos($_SERVER['REQUEST_URI'], 'products') !== false ? 'active bg-primary' : '' }}">
                <i class="fas fa-box me-2" style="width: 20px;"></i>
                Sản phẩm
            </a>
        </li>
        <li>
            <a href="/danhmuc/index" class="nav-link text-white {{ strpos($_SERVER['REQUEST_URI'], 'danhmuc') !== false ? 'active bg-primary' : '' }}">
                <i class="fas fa-list me-2" style="width: 20px;"></i>
                Danh mục
            </a>
        </li>
        <li>
            <a href="/thuonghieu/index" class="nav-link text-white {{ strpos($_SERVER['REQUEST_URI'], 'thuonghieu') !== false ? 'active bg-primary' : '' }}">
                <i class="fas fa-tags me-2" style="width: 20px;"></i>
                Thương hiệu
            </a>
        </li>
        <li>
            <a href="/orders" class="nav-link text-white {{ strpos($_SERVER['REQUEST_URI'], 'orders') !== false ? 'active bg-primary' : '' }}">
                <i class="fas fa-shopping-cart me-2" style="width: 20px;"></i>
                Đơn hàng
            </a>
        </li>
        <li>
            <a href="/users/index" class="nav-link text-white {{ strpos($_SERVER['REQUEST_URI'], 'users') !== false ? 'active bg-primary' : '' }}">
                <i class="fas fa-users me-2" style="width: 20px;"></i>
                Người dùng
            </a>
        </li>
        <li>
            <a href="/magiamgia/index" class="nav-link text-white {{ strpos($_SERVER['REQUEST_URI'], 'magiamgia') !== false ? 'active bg-primary' : '' }}">
                <i class="fas fa-percentage me-2" style="width: 20px;"></i>
                Mã giảm giá
            </a>
        </li>
          <li>
            <a href="/contacts/index" class="nav-link text-white {{ strpos($_SERVER['REQUEST_URI'], 'contacts') !== false ? 'active bg-primary' : '' }}">
                <i class="fas fa-envelope me-2" style="width: 20px;"></i>
                Liên hệ
            </a>
        </li>
        </li>
    </ul>
    <hr>
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center text-white text-decoration-none dropdown-toggle" id="dropdownUser1" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="rounded-circle bg-secondary d-flex justify-content-center align-items-center me-2" style="width: 32px; height: 32px;">
                <i class="fas fa-user"></i>
            </div>
            <strong>{{ $_SESSION['login']['ten'] ?? 'Admin' }}</strong>
        </a>
        <ul class="dropdown-menu dropdown-menu-dark text-small shadow" aria-labelledby="dropdownUser1">
            <li><a class="dropdown-item" href="#">Cài đặt</a></li>
            <li><a class="dropdown-item" href="#">Hồ sơ</a></li>
            <li><hr class="dropdown-divider"></li>
            <li><a class="dropdown-item" href="/auth/logout">Đăng xuất</a></li>
        </ul>
    </div>
</div>