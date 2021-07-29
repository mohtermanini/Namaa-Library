<?php
namespace App\Http\Traits;

trait Validator{
    public function checkIfDate($s){
        return preg_match("/^(\d{4})-(0[1-9]|1[0-2])-(0[1-9]|[12]\d|3[01])$/",$s);
    }
}

?>