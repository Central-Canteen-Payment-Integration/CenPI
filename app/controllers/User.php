<?php

class User extends Controller {
    private $userModel;
    private $trxModel;
    private $cartModel;

    public function __construct() {
        $this->userModel = $this->model('UserModel');
        $this->trxModel = $this->model('TrxModel');
        $this->cartModel = $this->model('CartModel');
    }

    public function login() {
        if (isset($_SESSION['user'])) {
            header('Location: /Home/menu');
            exit;
        }
    
        $data = [
            'page' => 'Login - CenPI',
            'error' => ''
        ];
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];
    
            $user = $this->userModel->login($username, $password);
    
            if ($user) {
                if ($user['ACTIVE'] == 0) {
                    $data['error'] = 'Please verify your account.';
                } else {
                    $_SESSION['user'] = [
                        'id' => $user['ID_USER'],
                        'email' => $user['EMAIL'],
                        'username' => $user['USERNAME'],
                    ];
                    header('Location: /Home/menu');
                    exit;
                }
            } else {
                $data['error'] = 'Invalid username or password';
            }
        }
        $this->view('templates/init', $data);
        $this->view('user/login', $data);
    }

    public function register() {
        if (isset($_SESSION['user'])) {
            header('Location: /Home/menu');
            exit;
        }
    
        $data = [
            'page' => 'Register - CenPI',
            'error' => ''
        ];
    
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = htmlspecialchars($_POST['username']);
            $password = $_POST['password'];
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        
            if (empty($username) || empty($password) || empty($email)) {
                $data['error'] = 'All fields must be filled.';
            } else {
                $existingUsers = $this->userModel->findUserByUsernameOrEmail($username, $email);
                $userCount = count($existingUsers);
                if ($userCount === 2) {
                    $data['error'] = 'Email and username already used.';
                } elseif ($userCount === 1) {
                    if ($existingUsers[0]['USERNAME'] === $username && $existingUsers[0]['EMAIL'] === $email) {
                        $data['error'] = 'Email and username already used.';
                    } elseif ($existingUsers[0]['EMAIL'] === $email) {
                        if ($existingUsers[0]['ACTIVE'] == 0) {
                            $data['error'] = 'Please verify your account.';
                        } else {
                            $data['error'] = 'Email already used.';
                        }
                    } else {
                        $data['error'] = 'Username already used.';
                    }
                } else {
                    if ($this->userModel->register($username, $password, $email)) {
                        header('Location: /User /login');
                        exit;
                    } else {
                        $data['error'] = 'Registration failed. Please try again.';
                    }
                }
            }
        }

        $this->view('templates/init', $data);
        $this->view('user/login', $data);
    }

    public function verify($token) {
        $verificationMessage = $this->userModel->verifyUser ($token);
        
        $loginLink = '<a href="http://cenpi.test/User/login">Click here to log in</a>';
        
        echo $verificationMessage . '<br>' . $loginLink;
        
        exit;
    }

    public function profile() {
        if (!isset($_SESSION['user'])) {
            header('Location: /User/login');
            exit;
        } else {
            $user = $_SESSION['user'];
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $username = htmlspecialchars($_POST['username']);
                $birthdate = $_POST['birthdate'];
                $phone_number = $_POST['phone_number'];
                $currentPassword = $_POST['currentPassword'];
                $newPassword = $_POST['newPassword'];
                $confirmNewPassword = $_POST['confirmNewPassword'];
    
                if (!$this->userModel->verifyPassword($user, $currentPassword)) {
                    $_SESSION['error'] = 'Current password is incorrect.';
                    header('Location: /User/profile');
                    exit;
                }
    
                $hashedNewPassword = null;
                if (!empty($newPassword)) {
                    if ($newPassword !== $confirmNewPassword) {
                        $_SESSION['error'] = 'New password and confirmation do not match.';
                        header('Location: /User/profile');
                        exit;
                    }
                    $hashedNewPassword = password_hash($newPassword, PASSWORD_BCRYPT);
                }
    
                $isUpdated = $this->userModel->updateUserProfile($user, $username, $birthdate, $phone_number, $hashedNewPassword);
    
                if ($isUpdated) {
                    $_SESSION['success'] = 'Profile updated successfully.';
                    header('Location: /User/profile');
                } else {
                    $_SESSION['error'] = 'Failed to update profile.';
                    header('Location: /User/profile');
                }
    
                exit;
            }
            $user = $_SESSION['user'];
            $data = [
                'page' => 'Profile - CenPI',
                'error' => '',
                'cart' => $this->cartModel->getCartUser($user['id'])
            ];
            $this->view('templates/init', $data);
            $this->view('templates/header', $data);
            $this->view('User/profile', $user);
            $this->view('templates/footer');
        }
    }

    public function logout() {
        session_destroy();
        header("Location: /Home/menu");
        exit();
    }

    public function order() {
        $this->trxModel->checkExpiredOrder($_SESSION['user']['id']);
        $data = [
            'page' => 'My Orders - CenPI',
            'error' => '',
            'cart' => ''
        ];

        if (isset($_SESSION['user'])) {
            $user = $_SESSION['user'];
            $data['cart'] = $this->cartModel->getCartUser($user['id']); 
        } else {
            header('Location: /Home/menu');
        }

        $this->view('templates/init', $data);
        $data['orders'] = $this->trxModel->getTransactionByUserId($_SESSION['user']['id']);
        $this->view('templates/header', $data);
        $this->view('user/order', $data);
        $this->view('templates/footer');
    }
}