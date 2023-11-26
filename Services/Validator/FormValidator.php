<?php
declare(strict_types=1);

namespace Services\Validator;
class FormValidator
{
    private $error;
    
    public function __construct(){
        $this->error = [ ];
    }
    
    public function validMail(string $mailValue): void
    {
        // built-in function to check email format
        if(!filter_var($mailValue, FILTER_VALIDATE_EMAIL) || empty($mailValue)){
            array_push($this->error, $mailValue);
        }
    }
    
    public function validLength(string $value, int $max, int $min): void
    {   
        //check length
        if(strlen($value) < $min || strlen($value) > $max){
            array_push($this->error, $value);
        }
    }
    
    public function validUsername(string $username)
    { 
        // email can't contain special characters
        if(!preg_match("/^[a-zA-Z0-9]*$/", $username)){
            array_push($this->error, $username);
        }
    }
    
     public function getError(): bool
    {
        $isValid = true;
        if(!empty($this->error)) {
            $isValid = false;
        } 
        return $isValid;
    }
}
