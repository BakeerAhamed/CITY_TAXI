<?php

class AutoPassword {
    public function generatePassword($length) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()';
        $charactersLength = strlen($characters);
        $randomPassword = '';
        for ($i = 0; $i < $length; $i++) {
            $randomPassword .=$characters[rand(0, $charactersLength - 1)];
        }
        return $randomPassword;
    }
}

// Example usage
/*
$passwordGenerator = new PasswordGenerator();
echo $passwordGenerator->generatePassword(8);
*/
?>
