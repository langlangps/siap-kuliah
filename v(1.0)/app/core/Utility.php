<?php

class Utility
{
    private $formValid = false;

    public function str_rand_gen($length = 8)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function get_flash_data($keyFlash)
    {
        if (isset($_SESSION['flash-message'][$keyFlash])) {
            $flash_data = $_SESSION['flash-message'][$keyFlash];
            unset($_SESSION['flash-message'][$keyFlash]);
            return $flash_data;
        }
        return null;
    }
    public function get_flash_message()
    {
        $flash_message = '';
        if (isset($_SESSION['flash-message'])) {
            $flash_message = $_SESSION['flash-message'];
            unset($_SESSION['flash-message']);
        }
        return $flash_message;
    }

    public function set_flash_message($key, $flash_message = null)
    {
        $_SESSION['flash-message'][$key] = $flash_message;
    }


    public function formValidation_minLength($postKey, $num, $flashKey = null, $message = null)
    {
        if (is_null($message)) {
            $message = "Minimal terdapat $num huruf";
        }
        if (is_null($flashKey)) {
            $flashKey = $postKey;
        }


        if (isset($_POST[$postKey])) {
            if (strlen($_POST[$postKey]) >= $num) {
                // Jika panjang isi form tidak kurang dari ketentuan
                $this->formValid = true;
                return;
            }
            // Jika panjang isi form kurang dari ketentuan
            $this->set_flash_message($flashKey, $message);
            $this->formValid = false;
        }
    }

    public function formValidation_required($postKey,  $flashKey = null, $message = null)
    {
        if (is_null($message)) {
            $message = "Form harus diisi";
        }
        if (is_null($flashKey)) {
            $flashKey = $postKey;
        }

        if (isset($_POST[$postKey])) {
            if (strlen($_POST[$postKey]) > 0) {
                // Jika form tidak kosong
                $this->formValid = true;
                return;
            }
            // Jika form kosong
            $this->set_flash_message($flashKey, $message);
            $this->formValid = false;
        }
    }

    public function formValidation_password($postKey, $password, $flashKey = null, $message = null)
    {
        if (is_null($message)) {
            $message = "Password tidak sesuai";
        }
        if (is_null($flashKey)) {
            $flashKey = $postKey;
        }

        if (isset($_POST[$postKey])) {
            // false jika tidak sama, true jika sama
            $hash = password_hash($_POST[$postKey], PASSWORD_DEFAULT);
            if (password_verify($_POST[$postKey], $password)) {
                $this->formValid = true;
                return;
            }
            $this->set_flash_message($flashKey, $message);
            $this->formValid = false;
        }
    }

    public function formValidate_run()
    {
        $formValid = $this->formValid;
        $this->formValid = false;
        return $formValid;
    }
}