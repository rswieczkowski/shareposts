<?php

declare(strict_types=1);

class Users extends Controller
{

    private User $userModel;

    public function __construct()
    {
        $this->userModel = $this->model('User');
    }

    public function register()
    {
        // Check for POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process the form
            $data = [
                'name' => htmlspecialchars(trim($_POST['name']), ENT_QUOTES),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'repeat_password' => trim($_POST['repeat_password']),
                'name_error' => '',
                'email_error' => '',
                'password_error' => '',
                'repeat_password_error' => ''
            ];


            // Validate an email
            $validEmail = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
            if (empty($data['email'])) {
                $data['email_error'] = 'Please enter an email';
            } elseif (!$validEmail) {
                $data['email_error'] = 'Please enter a valid email';
            } else {
                // Check if email exists
                if ($this->userModel->getUserByEmail($data['email'])) {
                    $data['email_error'] = 'Email is already taken';
                }
            }

            // Validate name
            if (empty($data['name'])) {
                $data['name_error'] = 'Please enter your name';
            }

            // Validate a password
            $validPassword = preg_match("/^([a-zA-Z0-9@#-_$%^&+=!?]{6,20})$/", $_POST['password']);
            if (empty($data['password'])) {
                $data['password_error'] = 'Please enter password';
            } elseif (!$validPassword) {
                $data['password_error'] = 'Please enter valid password between 6 and 20 characters';
            }

            // Validate repeat password
            if (empty($data['repeat_password'])) {
                $data['repeat_password_error'] = 'Please repeat password';
            } elseif ($data['password'] !== $data['repeat_password']) {
                $data['repeat_password_error'] = 'Passwords don\'t match';
            }

            // Make sure errors are empty
            if (empty($data['name_error']) && empty($data['email_error']) && empty($data['password_error']) && empty($data['repeat_password_error'])) {
                // Hash password
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);

                // Register user
                if ($this->userModel->registerUser($data)) {
                    $message = 'You are registered and can log in';
                    flash('register_success', $message);
                    redirect('users/login');
                } else {
                    die('Something went wrong');
                }
            } else {
                // Load view with errors
                $this->view('users/register', $data);
            }
        } else {
            // Init data
            $data = [
                'name' => '',
                'email' => '',
                'password' => '',
                'repeat_password' => '',
                'name_error' => '',
                'email_error' => '',
                'password_error' => '',
                'repeat_password_error' => ''
            ];
            // Load view

            $this->view('users/register', $data);
        }
    }

    public function login()
    {
        // Check for POST
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Process the form
            $data = [
                'email' => trim($_POST['email']),
                'password' => $_POST['password'],
                'email_error' => '',
                'password_error' => '',
            ];

            // Validate an email
            $validEmail = filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL);
            if (empty($data['email'])) {
                $data['email_error'] = 'Please enter an email';
            } elseif (!$validEmail) {
                $data['email_error'] = 'Please enter a valid email';
            }

            // Validate a password
            $validPassword = preg_match("/^([a-zA-Z0-9@#-_$%^&+=!?]{6,20})$/", $_POST['password']);
            if (empty($data['password'])) {
                $data['password_error'] = 'Please enter password';
            } elseif (!$validPassword) {
                $data['password_error'] = 'Please enter valid password between 6 and 20 characters';
            }

            // Check for users/email
            $userFound = $this->userModel->getUserByEmail($data['email']);
            if (!$userFound) {
                // User does not exist
                $data['email_error'] = 'User does not exist';
            } else {
                // Check and set logged-in user
                $isUserLoggedIn = $this->userModel->isPasswordCorrect($data['email'], $data['password']);

                if (!$isUserLoggedIn) {
                    $data['password_error'] = 'Incorrect password';
                } else {
                    // Create Session
                    $userLogged = $this->userModel->getDb()->getSingleRecord();
                    $this->createUserSession($userLogged);
                }
            }
            // Check for error
            if (empty($data['email_error']) && empty($data['password_error'])) {
                die('error');
            } else {
                $this->view('users/login', $data);
            }
        } else {
            // Init data
            $data = [
                'email' => '',
                'email_error' => '',
                'password' => '',
                'password_error' => ''
            ];
            // Load view

            $this->view('users/login', $data);
        }
    }

    private function createUserSession(object $user): void
    {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['name'] = $user->name;
        $_SESSION['email'] = $user->email;

        redirect('pages/index');
    }

    public function logout(): void
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['name']);
        unset($_SESSION['email']);
        session_destroy();
        redirect('posts');
    }


}