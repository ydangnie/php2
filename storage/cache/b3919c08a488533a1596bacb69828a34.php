<nav class="navbar navbar-expand-lg bg-white border-bottom sticky-top">
    <div class="container">
      <a class="navbar-brand fw-semibold" href="/home/trangchu"><img src="https://theme.hstatic.net/1000306633/1001194548/14/logo.png?v=491" alt="" width="200px"></a>
  
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
        <span class="navbar-toggler-icon"></span>
      </button>
  
      <div id="nav" class="collapse navbar-collapse">
        <ul class="navbar-nav me-auto">
          <li class="nav-item"><a class="nav-link active" href="/">Home</a></li>
  
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
              Admin
            </a>
            <ul class="dropdown-menu">
              <li><a class="dropdown-item" href="<?php echo e(route('products.index')); ?>">Sản phẩm</a></li>
              <li><a class="dropdown-item" href="/danhmuc/index">Danh mục</a></li>
              <li><a class="dropdown-item" href="/thuonghieu/index">Thương hiệu</a></li>
              <li><a class="dropdown-item" href="/tintuc/index">Tin tức</a></li>
              <li><a class="dropdown-item" href="/users/index">Người dùng</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#">All Categories</a></li>
            </ul>
          </li>
        </ul>
  
        <div class="d-flex align-items-center gap-3 mt-3 mt-lg-0">
          
          <form class="d-flex" role="search">
            <div class="input-group">
                <input class="form-control border-end-0 rounded-0" type="search" placeholder="Tìm sản phẩm..." />
                <button class="btn btn-outline-dark border-start-0 rounded-0" type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </div>
          </form>
  
          <a href="/cart" class="position-relative text-dark ms-2 text-decoration-none" title="Giỏ hàng">
              <i class="fas fa-shopping-bag fa-lg"></i>
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-black text-white" style="font-size: 0.6rem;">
                  0
              </span>
          </a>
  
          <?php if(isset($_SESSION['login'])): ?>
              <div class="dropdown ms-2">
                  <a class="text-dark text-decoration-none dropdown-toggle fw-bold" href="#" role="button" data-bs-toggle="dropdown">
                      <i class="fas fa-user-circle me-1"></i> 
                      <?php echo e($_SESSION['login']['ten'] ?? 'Member'); ?>

                  
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end rounded-0 mt-2 shadow-sm">
                      <li><a class="dropdown-item" href="/profile"><i class="fas fa-id-card me-2 text-muted"></i>Hồ sơ</a></li>
                      <li><a class="dropdown-item" href="/orders"><i class="fas fa-box me-2 text-muted"></i>Đơn hàng</a></li>
                      <li><hr class="dropdown-divider"></li>
                      <li><a class="dropdown-item text-danger" href="/auth/logout"><i class="fas fa-sign-out-alt me-2"></i>Đăng xuất</a></li>
                  </ul>
              </div>
          <?php else: ?>
              <div class="ms-2">
                  <a href="/auth/dangnhap" class="btn btn-dark btn-sm rounded-0 px-3 fw-bold">
                      Đăng nhập
                  </a>
              </div>
          <?php endif; ?>
  
        </div>
      </div>
    </div>
</nav><?php /**PATH C:\xampp\htdocs\all_php\php11\app\views/layout/nav.blade.php ENDPATH**/ ?>