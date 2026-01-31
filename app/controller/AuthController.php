<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class AuthController extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = $this->model('UsersModel');
    }

    // Trang đăng nhập
    public function login() {
        if (isset($_SESSION['user'])) {
            $this->redirect('/');
        }
        $this->view('auth.login'); // Tạo file view/auth/login.blade.php
    }

    // Xử lý đăng nhập
    public function postLogin() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ten = $_POST['ten'];
            $matkhau = $_POST['matkhau'];
            
            $user = $this->userModel->timnguoidung($ten);
            
            // Kiểm tra pass (Lưu ý: Code cũ bạn dùng password_hash, nên phải dùng password_verify)
            if ($user && password_verify($matkhau, $user['matkhau'])) {
                $_SESSION['user'] = $user;
                if ($user['role'] == 'admin') {
                    $this->redirect('/admin/dashboard');
                } else {
                    $this->redirect('/');
                }
            } else {
                $_SESSION['error'] = "Sai tên đăng nhập hoặc mật khẩu!";
                $this->redirect('/auth/login');
            }
        }
    }

    // Đăng ký
    public function register() {
        $this->view('auth.register');
    }

    public function postRegister() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ten = $_POST['ten'];
            $matkhau = password_hash($_POST['matkhau'], PASSWORD_DEFAULT); // Mã hóa pass
            
            // Kiểm tra trùng tên
            if ($this->userModel->timnguoidung($ten)) {
                $_SESSION['error'] = "Tên tài khoản đã tồn tại!";
                $this->redirect('/auth/register');
                return;
            }

            $this->userModel->create([
                'ten' => $ten,
                'matkhau' => $matkhau,
                'role' => 'nguoidung'
            ]);
            
            $_SESSION['success'] = "Đăng ký thành công! Hãy đăng nhập.";
            $this->redirect('/auth/login');
        }
    }

    // Quên mật khẩu (Gửi OTP)
    public function forgotPassword() {
        $this->view('auth.forgot');
    }

    public function sendOtp() {
        if (isset($_POST['email'])) { // Giả sử bảng login có cột email, nếu chưa có bạn phải thêm vào DB
            $email = $_POST['email'];
            $otp = rand(100000, 999999);
            $_SESSION['otp'] = $otp;
            $_SESSION['reset_email'] = $email;

            // Gửi mail dùng PHPMailer
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = $_ENV['MAIL_HOST'];
                $mail->SMTPAuth = true;
                $mail->Username = $_ENV['MAIL_USER'];
                $mail->Password = $_ENV['MAIL_PASS'];
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = $_ENV['MAIL_PORT'];

                $mail->setFrom($_ENV['MAIL_USER'], 'Admin Shop');
                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = 'Mã OTP đặt lại mật khẩu';
                $mail->Body    = 'Mã OTP của bạn là: <b>' . $otp . '</b>';

                $mail->send();
                $_SESSION['success'] = "Đã gửi OTP qua email.";
                $this->view('auth.verify_otp');
            } catch (Exception $e) {
                echo "Lỗi gửi mail: {$mail->ErrorInfo}";
            }
        }
    }

    public function logout() {
        unset($_SESSION['user']);
        session_destroy();
        $this->redirect('/');
    }
}