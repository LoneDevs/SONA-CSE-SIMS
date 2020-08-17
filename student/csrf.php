<?php

function getKey(){
    $key = bin2hex(random_bytes(32)); // csrf key
    return $key;

}

function getToken($key){
    return hash_hmac('sha256',"token",$key);
}

function csrfError(){
    echo '<div class="alert alert-danger" role="alert"> Invalid CSRF Token Refresh page </div><br>';
}