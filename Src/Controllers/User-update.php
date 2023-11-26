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
if( $_SESSION['id'] == "")
{
    header('Location: index.php?url=coin');
}

// Check if the id is present and then if it exists in the database
if( isset($_GET['id'])) {
    $id = $_GET['id'];

    if( isset ($userModel->getUser($id)->user_name) ) { // check if find a user from the id
        
        $dbusername = $userModel->getUser($id)->user_name;
        $dbemail = $userModel->getEmail($id)->email;
        $dbrole = $userModel->getRole($id)->role; 
    }
    else {
        
        header('Location: index.php?url=coin');
    } 
}
else {
    header('Location: index.php?url=coin');
}  

// Validator        
if(isset($_POST['update'])){

    $username = $_POST['username'];
    $email = $_POST['email'];
    $pw = $_POST['password'];
    
    $role = "";
    if( $_SESSION['role'] == "1"){ // Only admin can modify this data
        $role = $_POST['role'];
    }
    
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
    if ($pw !== "") {
        $form->validLength($pw, 20, 6);
        $checkPassword->validLength($pw, 20, 6);
        $isValidPassword = $checkPassword->getError();
    }


    $isValid = $form->getError();
}


//Message unvalid username
if (isset($isValidUsername) && !$isValidUsername){
    $message = 'Username must not contain special characters !';
}

//Message unvalid username
if (isset($isValidUsernamelength) && !$isValidUsernamelength){
    $message = 'Username must be between 2-10 characters !';
}

//Message unvalid email
if (isset($isValidMail) && !$isValidMail){
    $message = 'Email required!';
}

//Message unvalid password
if (isset($isValidPassword) &&!$isValidPassword){
     $message = 'Password must be between 6-20 characters !';
}



// Sending datas to the database
if(isset($isValid) && $isValid) {

    //Get the id from the url
    if( isset($_GET['id'])) {
        $id = $_GET['id'];
        
        // Check if username it's different from what's alteady in DB
        if ($username != $dbusername){
            if ( $username != "" ) {//Check if username is not empty
    
                $userModel->updateUserName($id,$username);
            }
            else{
                //Message : the field username was empty
                $message = 'Username is required';
            }
        }
        
        // Check if email different from what's already in DB
        if ($email != $dbemail) {
            
            //Check if email is not empty
            if ( $username != "" ) { 
           
                $count = $userModel->matchMail($email); 
                
                // Check if email already exists in DB
                if($count<=0) { 
                    $userModel->updateEmail($id,$email);
                }
                else {
                    $message = 'Email was taken';
                }
            }
            else{
                $message = 'Email is required';
            }
        }
        
        
        //Check if pw is not empty
        if ( $pw != "" ) {
            $userModel->updatePassword($id,$pw);
        }

       
        // Check if role's different from which in DB
        if ($role != $dbrole){
            //Check if role is not empty
            if ( $role != "" ) {
                $userModel->updateRole($id,$role);
            }
        }
        
        // Refresh the datas
        $dbusername = $userModel->getUser($id)->user_name;
        $dbemail = $userModel->getEmail($id)->email;
        $dbrole = $userModel->getRole($id)->role; 
        
        
        if ($_SESSION["role"] == 0 ){
            $_SESSION["user_name"] = $dbusername;
        }
    } 
    
    // else if (isset($isValid)){
    //     if(strlen($username)<2 || strlen($username)>30) {
    //         $message = 'username must be between 2-30 characters !';
    //     }
    //     if(strlen($pw)<6 || strlen($pw)>20) {
    //         $message = 'password must be between 6-20 characters !';
    //     }
    // }
}    


//Delete user
if(isset($_POST['delete'])){
    //Get the id from the url
    if( isset($_GET['id'])) {
        $id = $_GET['id'];
        //delete user by their id
        $userModel->deleteUser($id);

        // if you delete your own account
        if ($_GET['id'] == $_SESSION["id"]){
            header('Location: index.php?url=logout');
        }
        else
        {
            header('Location: index.php?url=user-index');
        }
        
    }
}


require_once '../Views/user-update.phtml';









