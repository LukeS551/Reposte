<?php
class Users extends Controller{
    public function __construct(){
        $this->userModel = $this->model('User');

    }

    public function register(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'confirm_password' => trim($_POST['password']),
                'password' => trim($_POST['password']),
                'name_error' => '',
                'email_error' => '',
                'password_error' => '',
                'confirm_password_error' => ''
            ];

            if(empty($data['email'])){
                $data['email_err'] = 'Please enter email';
            } else {
                if($this->userModel->findUserByEmail($data['email'])){
                    $data['email_err'] = 'an account with this email is already registered';
                }
            }

            if(empty($data['name'])){
                $data['name_err'] = 'Please enter email';
            }

            if(empty($data['password'])){
                $data['password_err'] = 'Please enter email';
            }
            elseif(strlen($data['password']) < 6){
                $data['password_err'] = 'Password must be at least 6 chars';
            }

            if(empty($data['confirm_password'])){
                $data['confirm_password_err'] = 'Please enter password';
            }
            else{
                if($data['password'] != $data['confirm_password'])
                {
                    $data['confirm_password_err'] = 'passwords don\'t match';
                }
            }

            if(empty($data['email_err']) && empty($data['name_err']) && empty($data['password_err'])  && empty($data['confirm_password_err'])){

                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                
                if($this->userModel->register($data)){
                    flash('register_success', 'You are registered and can log in');
                    redirect('users/login');
                } else {
                    die('Something went wrong');
                }
            }else {
                $this->view('users/register', $data);
            }

        } else {
            $data = [
                'name' => '',
                'email' => '',
                'confirm_password' => '',
                'password' => '',
                'name_error' => '',
                'email_error' => '',
                'password_error' => '',
                'confirm_password_error' => ''
            ];
            $this->view('users/register', $data);
        }
    }
    public function login(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){

            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'email' => trim($_POST['email']),
                'confirm_password' => trim($_POST['password']),
                'password' => trim($_POST['password']),
                'email_error' => '',
                'password_error' => '',
                'confirm_password_error' => ''
            ];

            if(empty($data['email'])){
                $data['email_err'] = 'Please enter email';
            }

            if($this->userModel->findUserByEmail($data['email'])){
            } else {
                $data['email_err'] = 'No user found';
            }

            if(empty($data['password'])){
                $data['password_err'] = 'Please enter password';
            }

            elseif(strlen($data['password']) < 6){
                $data['password_err'] = 'Password must be at least 6 chars';
            }
            if(empty($data['email_err']) && empty($data['password_err'])){
                
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);
                if($loggedInUser){
                    $this->createUserSession($loggedInUser);
                } else {
                    $data['password_err'] = 'password incorrect';
                    $this->view('users/login', $data);
                }
            }else {
                $this->view('users/login', $data);
            }
            

        } else {
            $data = [
                'email' => '',
                'password' => '',
                'email_error' => '',
                'password_error' => '',
            ];
            $this->view('users/login', $data);
        }
    }

    public function createUserSession($user){
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name;
        redirect('posts');
    }
    public function logout(){
        unset($_SESSION['user_id']);
        unset($_SESSION['user_id']);
        unset($_SESSION['user_id']);
        session_destroy();
        redirect('pages/login');
    }

}