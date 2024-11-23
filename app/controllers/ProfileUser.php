<?php

class ProfileUser extends Controller

{
    private $userModel;

    public function __construct()
    {
        $this->userModel = $this->model('UserModel');
    }

    public function showProfile()
    {
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
            $user = $this->userModel->getUserById($userId);

            $data = [
                'user' => $user,
                'message' => ''
            ];

            $this->view('User/profile', $data);
        } else {
            header('Location: /User/login');
            exit;
        }
    }

    public function updateProfile()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /User/login');
            exit;
        }

        $userId = $_SESSION['user_id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = htmlspecialchars($_POST['username']);
            $birthdate = $_POST['birthdate'];
            $phone_number = $_POST['phone_number'];
            $currentPassword = $_POST['currentPassword'];
            $newPassword = $_POST['newPassword'];
            $confirmNewPassword = $_POST['confirmNewPassword'];

            if (!$this->userModel->verifyPassword($userId, $currentPassword)) {
                $_SESSION['error'] = 'Current password is incorrect.';
                header('Location: /ProfileUser/showProfile');
                exit;
            }

            $hashedNewPassword = null;
            if (!empty($newPassword)) {
                if ($newPassword !== $confirmNewPassword) {
                    $_SESSION['error'] = 'New password and confirmation do not match.';
                    header('Location: /ProfileUser/showProfile');
                    exit;
                }
                $hashedNewPassword = password_hash($newPassword, PASSWORD_BCRYPT);
            }

            $isUpdated = $this->userModel->updateUserProfile($userId, $username, $birthdate, $phone_number, $hashedNewPassword);

            if ($isUpdated) {
                $_SESSION['success'] = 'Profile updated successfully.';
                header('Location: /ProfileUser/showProfile');
            } else {
                $_SESSION['error'] = 'Failed to update profile.';
                header('Location: /ProfileUser/showProfile');
            }

            exit;
        }

        $user = $this->userModel->getUserById($userId);
        $data = ['user' => $user];

        $this->view('User/profile', $data);
    }
}
