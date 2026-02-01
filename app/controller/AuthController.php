<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

use Google\Client as Google_Client;
use Google\Service\Oauth2 as Google_Service_Oauth2;
class AuthController extends Controller
{
    private $AuthModel;

    public function __construct()
    {
        $this->AuthModel = $this->model('AuthModel');
    }

    // Trang đăng nhập
    public function login()
    {
        if (isset($_SESSION['users'])) {
            $this->redirect('/');
        }
        $this->view('auth.login'); // Tạo file view/auth/login.blade.php
    }

    // Xử lý đăng nhập
    public function ktra()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $email = $_POST['email'];
            $matkhau = $_POST['matkhau'];

            $user = $this->AuthModel->timnguoidung($email);


            if ($user && password_verify($matkhau, $user['matkhau'])) {
                $_SESSION['users'] = $user;
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
    public function register()
    {
        $this->view('auth.register');
    }

    public function luu()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $email = $_POST['email'];
            $ten = $_POST['ten'];
            $matkhau = password_hash($_POST['matkhau'], PASSWORD_DEFAULT); // Mã hóa pass

            // Kiểm tra trùng tên
            if ($this->AuthModel->timnguoidung($email)) {
                $_SESSION['error'] = "Tên tài khoản đã tồn tại!";
                $this->redirect('/auth/register');
                return;
            }

            $this->AuthModel->create([
                'email' => $email,
                'ten' => $ten,
                'matkhau' => $matkhau,
                'role' => 'nguoidung'
            ]);

            $_SESSION['success'] = "Đăng ký thành công! Hãy đăng nhập.";
            $this->redirect('/auth/login');
        }
    }

    // Quên mật khẩu (Gửi OTP)
    public function forgot()
    {
        $this->view('auth.forgot');
    }

    public function gui_otp()
    {
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
                $this->view('auth.xacnhan');
            } catch (Exception $e) {
                echo "Lỗi gửi mail: {$mail->ErrorInfo}";
            }
        }
    }
    public function xacnhan()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $otp_input = $_POST['otp'];
            if (isset($_SESSION['otp']) && $otp_input == $_SESSION['otp']) {
                $this->view('auth.nhapmk');
            } else {
                echo "Nhập sai OTP";
                $this->view('auth.forgot');
            }
        }
    }


    public function nhapmk()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $matkhaumoi = $_POST['matkhaumoi'];
            $email = $_SESSION['reset_email'];



            $mahoa = password_hash($matkhaumoi, PASSWORD_DEFAULT);
            $this->AuthModel->nhapmk($email, $mahoa);

            unset($_SESSION['otp']);
            unset($_SESSION['reset_email']);


            $_SESSION['success'] = "Đổi mật khẩu thành công. Vui lòng đăng nhập!";
            $this->redirect('/auth/login');
        }
    }
    public function logout()
    {
        unset($_SESSION['user']);
        session_destroy();
        $this->redirect('/');
    }
    public function dnhapgoogle() {
        $client = new Google_Client();
        
        // Lấy cấu hình từ file .env
        $client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
        $client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
        
        // Đường dẫn này phải trùng KHỚP 100% trong Google Cloud Console
        $client->setRedirectUri('http://localhost:8000/auth/googleCallback'); 
        
        $client->addScope("email");
        $client->addScope("profile");

        $loginUrl = $client->createAuthUrl();
        header("Location: " . $loginUrl);
        exit;
    }
    public function googleCallback() {
        
        $client = new Google_Client();
        $client->setClientId($_ENV['GOOGLE_CLIENT_ID']);
        $client->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
        $client->setRedirectUri('http://localhost:8000/auth/googleCallback');

        if (isset($_GET['code'])) {
            try {
                // Đổi mã code lấy Token
                $token = $client->fetchAccessTokenWithAuthCode($_GET['code']);
                
                if (!isset($token['error'])) {
                    $client->setAccessToken($token['access_token']);

                    // Lấy thông tin người dùng từ Google
                    $google_oauth = new Google_Service_Oauth2($client);
                    $google_account_info = $google_oauth->userinfo->get();
                    
                    $email = $google_account_info->email;
                    $name = $google_account_info->name;
                    $google_id = $google_account_info->id;

                    // Gọi Model: Kiểm tra user đã tồn tại chưa
                    $user = $this->AuthModel->checkGoogleUser($email);

                    if ($user) {
                        // A. Đã tồn tại -> Lưu session đăng nhập luôn
                        $_SESSION['user'] = $user;
                        
                        // Cập nhật lại google_id vào DB nếu trước đó chưa có (trường hợp user cũ giờ mới link GG)
                        // (Bạn có thể viết thêm hàm update nếu cần, nhưng tạm thời login được là ổn)
                    } else {
                        // B. Chưa tồn tại -> Tạo user mới
                        $this->AuthModel->createGoogleUser($email, $name, $google_id);
                        
                        // Lấy lại thông tin vừa tạo để lưu session
                        $newUser = $this->AuthModel->checkGoogleUser($email);
                        $_SESSION['user'] = $newUser;
                    }

                    // Chuyển hướng về trang chủ hoặc Dashboard
                    if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] == 'admin') {
                         $this->redirect('/admin/dashboard');
                    } else {
                         $this->redirect('/');
                    }
                    exit;
                }
            } catch (Exception $e) {
                // Xử lý lỗi nếu kết nối Google thất bại
                $_SESSION['error'] = "Lỗi đăng nhập Google: " . $e->getMessage();
                $this->redirect('/auth/login');
            }
        }
        
        // Nếu không có code hoặc lỗi
        $this->redirect('/auth/login');
    }
}
