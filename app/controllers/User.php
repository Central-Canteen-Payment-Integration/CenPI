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
                    header('Location: /Menu');
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
            header('Location: /Menu');
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
            $data = [
                'page' => 'Profile - CenPI',
                'error' => ''
            ];
            $this->view('templates/init', $data);
            $this->view('User/profile', $user);
        }
    }

    public function logout() {
        session_destroy();
        header("Location: /Menu");
        exit();
    }

    public function history(){
        $data = [
            'page' => 'History - CenPI',
            'error' => ''
        ];
        $this->view('templates/init', $data);
        $this->view('user/history', $data);
    }
}