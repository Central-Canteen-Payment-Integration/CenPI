<?php

class User extends Controller {
    private $userModel;

    public function __construct() {
        $this->userModel = $this->model('UserModel');
    }

    public function login() {
        if (isset($_SESSION['user'])) {
            header('Location: /Menu');
            exit;
        }

        $data = [
            'page' => 'login'
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'];
            $password = $_POST['password'];

            $user = $this->userModel->login($username, $password);

            if ($user) {
                $_SESSION['user'] = [
                    'id' => $user['ID_USER'],
                    'email' => $user['EMAIL'],
                    'username' => $user['USERNAME'],
                ];
                header('Location: /Menu');
                exit;
            } else {
                $data['error'] = 'Invalid username or password';
            }
        }

        $this->view('user/login', $data);
    }

    public function register() {
        if (isset($_SESSION['user'])) {
            header('Location: /Menu');
            exit;
        }

        $data = [
            'page' => 'register',
            'error' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = htmlspecialchars($_POST['username']);
            $password = $_POST['password'];
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);

            if (empty($username) || empty($password) || empty($email)) {
                $data['error'] = 'All fields must be filled.';
            } else {
                if ($this->userModel->register($username, $password, $email)) {
                    header('Location: /User/login');
                    exit;
                } else {
                    $data['error'] = 'Registration failed. Please try again.';
                }
            }
        }

        $this->view('user/login_register', $data);
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
            $data = ['user' => $user];
            $this->view('User/profile', $user);
        }
    }

    public function logout() {
        session_destroy();
        header("Location: /Menu");
        exit();
    }
}