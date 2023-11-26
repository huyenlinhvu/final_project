<?php
use App\Models\User;
use Services\Session\Session;
Session::init();

// We check if there is a session as admin
if( $_SESSION['role'] != "1")
{
    header('Location: index.php?url=coin');
}


//Create the object User
$table_user = new User();
$title = "User Manager";

//Load the datas for users
$all_user = $table_user->getAllUsers();

if(isset($_POST['delete'])){
    $id = $_POST['user_id'];
    $table_user->deleteUser($id);
    
    // if you delete your own account
    if ($_POST['user_id'] == $_SESSION["id"]){
        header('Location: index.php?url=logout');
    }
    else
    {
        header('Location: index.php?url=user-index');
    }
}

require_once '../Views/user-index.phtml';
