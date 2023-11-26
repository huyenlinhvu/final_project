<?php
use App\Models\User;
use Services\Session\Session;
use Services\Validator\FormValidator;
use Services\Validator\TextValidator;

$userModel = new User();
$form = new FormValidator();
$checkUsername = new FormValidator();
$checkUsernamelength = new FormValidator();
$checkMail = new FormValidator();
$checkPassword = new FormValidator();
$text = new TextValidator();

Session::init();

// Check if there is a session
if(isset($_SESSION['user_name'])){
    header('Location: index.php?url=coin');
}


//Check log in conditions
if(isset($_POST['form']) && $_POST['form']=='signIn'){

    $checkPassword=false;
    
    if(empty($_POST['email']) && empty($_POST['password'])){
        $message = 'Please log in with your email and password';        
    }
    else{
        $email = $_POST['email'];
        $pw = $_POST['password'];
        
        // check if the email exists in DB        
        $count = $userModel->matchMail($email);
        if($count>0){
            $user = $userModel->getUserEmail($email);
            $checkPassword = password_verify($pw, $user->password);
        }
        
        //redirect to page Coins if pw is correct, set session
        if(isset($checkPassword) && $checkPassword) {
            Session::init();
            $_SESSION['email'] = $user->email;
            $_SESSION['user_name'] = $user->user_name;
            $_SESSION['id'] = $user->id;
            $_SESSION['password'] = $user->password;
            $_SESSION['role'] = $user->role; 
            $message = 'success';
            header('Location: index.php?url=coin');
            }
        else {
            $message = 'Incorrect email or password';
            }
    }
} 


//Create an account
if(isset($_POST['form']) && $_POST['form']=='signUp' ){

    $username = $_POST['username'];
    $email = $_POST['email'];
    $pw = $_POST['password'];
   
    // Valid username
    $form->validUsername($username);
    $checkUsername->validUsername($username);
    $isValidUsername = $checkUsername->getError();
    
    $form->validLength($username, 10, 2);
    $checkUsernamelength->validLength($username, 10, 2);
    $isValidUsernamelength = $checkUsernamelength->getError();
  
    // Valid email
    $form->validMail($email);
    $checkMail->validMail($email);
    $isValidMail = $checkMail->getError();

    // Valid password
    $form->validLength($pw, 20, 6);
    $checkPassword->validLength($pw, 20, 6);
    $isValidPassword = $checkPassword->getError();


    $isValid = $form->getError();
}

if (isset($isValidUsername) && !$isValidUsername){

    $message = 'Username must not contain special characters !';
}

else if (isset($isValidUsernamelength) && !$isValidUsernamelength){

    $message = 'Username must be between 2-10 characters !';
}

else if (isset($isValidMail) && !$isValidMail){

    $message = 'Email required !';
}

else if (isset($isValidPassword) && !$isValidPassword){

     $message = 'Password must be between 6-20 characters !';
}


    //Check if the email already in DB, if not insert
    if(isset($isValid) && $isValid) {

        $count = $userModel->matchMail($email);
        if($count>0){
            $message = 'Email is already taken !';
        } 
        else{
            $userModel->insertUser($username, $email, $pw);
            $message = 'You have successfelly created your account !';
        }
    } 




//Check which form user clicks
$_GET['block'] = $_GET['block'] ?? 'signIn';

require_once '../Views/login.phtml';










