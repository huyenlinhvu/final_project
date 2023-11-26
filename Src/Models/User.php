<?php
declare(strict_types=1);
namespace App\Models;

class User extends AbstractModel
{
    //Function to create new user
    public function insertUser($name, $email, $pw){
        $sql = 'INSERT INTO users (user_name, email, password) VALUE (:user_name, :email, :password)';
        $param = [
            ':user_name'=>$name,
            ':email'=>$email,
            ':password'=>password_hash($pw, PASSWORD_DEFAULT)
        ];
        return $this->insert($sql, $param);
    }
    
    //Function to delete an user
    public function deleteUser($id)
    {
        $sql = 'DELETE FROM `users` where id=:id';
        $param = [
            ':id'=>$id
        ];
        return $this->remove($sql, $param);
    }
    
    //Function to update a user from the id
    public function updateUser($id, $name, $email, $pw, $role){

        $sql = 'UPDATE users SET user_name=:user_name, email=:email, password=:password, role=:role WHERE id=:id';
        $param = [
            ':id'=>$id,         
            ':user_name'=>$name,
            ':email'=>$email,
            ':password'=>password_hash($pw, PASSWORD_DEFAULT),
            ':role'=>$role
        ];
        return $this->update($sql, $param);
    }
    
    //Function to update a user_name from the id
    public function updateUserName($id, $name){

        $sql = 'UPDATE users SET user_name=:user_name WHERE id=:id';
        $param = [
            ':id'=>$id,         
            ':user_name'=>$name
        ];
        return $this->update($sql, $param);
    }
    
     //Function to update a email from the id
    public function updateEmail($id, $email){

        $sql = 'UPDATE users SET email=:email WHERE id=:id';
        $param = [
            ':id'=>$id,         
            ':email'=>$email
        ];
        return $this->update($sql, $param);
    }
    
    //Function to update a password from the id
    public function updatePassword($id, $pw){

        $sql = 'UPDATE users SET password=:password WHERE id=:id';
        $param = [
            ':id'=>$id,         
            ':password'=>password_hash($pw, PASSWORD_DEFAULT),
        ];
        return $this->update($sql, $param);
    }
    
    //Function to update a user from the id
    public function updateRole($id, $role){

        $sql = 'UPDATE users SET role=:role WHERE id=:id';
        $param = [
            ':id'=>$id,
            ':role'=>$role
        ];
        return $this->update($sql, $param);
    }
    
    //Function to get user from id
    public function getUser($id){
        $sql = 'SELECT user_name from users WHERE id = :id';
        $param = [':id'=>$id];
        return $this->findOne($sql, $param);
    }
    
    //Function to get email from id
    public function getEmail($id){
        $sql = 'SELECT email from users WHERE id = :id';
        $param = [':id'=>$id];
        return $this->findOne($sql, $param);
    }
    
    //Function to get role from id
    public function getRole($id){
        $sql = 'SELECT role from users WHERE id = :id';
        $param = [':id'=>$id];
        return $this->findOne($sql, $param);
    }
    
    
    //Function to get user from email
    public function getUserEmail($mail){
        $sql = 'SELECT * from users WHERE email = :email';
        $param = [':email'=>$mail];
        return $this->findOne($sql, $param);
    }
    
    //Function to get all users
    public function getAllUsers(){
        $sql = 'SELECT * from users';
        return $this->findAll($sql);
    }
    
    //Function to check if email exists in db
    public function matchMail($mail){
        $sql = 'SELECT id from users WHERE email = :email';
        $param = [':email'=>$mail];
        return $this->countRow($sql, $param);
    }
    
    //Function to add a search from the id of the user
    public function updateSearch($id, $search){

        $sql = 'UPDATE users SET search=:search WHERE id=:id';
        $param = [
            ':id'=>$id,         
            ':search'=>$search
        ];
        return $this->update($sql, $param);
    }
    
    //Function to get user from email
    public function getSearch($id){
        $sql = 'SELECT search from users WHERE id = :id';
        $param = [':id'=>$id];
        return $this->findOne($sql, $param);
    }
}

