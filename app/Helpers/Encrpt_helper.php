<?php

function encrypt_url($data)
{
    $key = '5Yz64c70b0b8d45m';
    $encrypt =  openssl_encrypt($data, 'aes-256-cbc', $key, 0, $key);
    return base64_encode($encrypt);
}

function decrypt_url($data)
{
    $key = '5Yz64c70b0b8d45m';
    $dataDecode = base64_decode($data);
    $encrypt =  openssl_decrypt($dataDecode, 'aes-256-cbc', $key, 0, $key);
    return $encrypt;
}
