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

//Only admin can access this page
if( $_SESSION['role'] != "1")
{
    header('Location: index.php?url=coin');
}

//Add a new user
if(isset($_POST['add-user'])){

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
    $message = 'Email required!';
}

else if (isset($isValidPassword) && !$isValidPassword){
     $message = 'Password must be between 6-20 characters !';
}


    //Check if the email already in DB, if not insert
    if(isset($isValid) && $isValid) {

        $count = $userModel->matchMail($email);
        if($count>0){
            $message = 'Email was taken';
        } 
        else{
            $userModel->insertUser($username, $email, $pw);
            $message = 'You have successfelly added an user';
        }
    } 



require_once '../Views/add-user.phtml';
