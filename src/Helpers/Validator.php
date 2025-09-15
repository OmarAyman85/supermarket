<?php

namespace SuperMarket\Helpers;

class Validator{

    public function getCategoryValidationError(array $data) : array{
        $errors = [];
        if (empty($data["name"])){
            $errors[] = "name is required!";
        }
        return $errors;
    }
    
}
?>