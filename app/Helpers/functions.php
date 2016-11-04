<?php
function encryptToken($data, $key='baizhikang')
{
    $char = '';
    $str = '';
    $key = md5($key);
    $x  = 0;
    $len = strlen($data);
    $l  = strlen($key);
    for ($i = 0; $i < $len; $i++)
    {
        if ($x == $l) 
        {
         $x = 0;
        }
        $char .= $key{$x};
        $x++;
    }
    for ($i = 0; $i < $len; $i++)
    {
        $str .= chr(ord($data{$i}) + (ord($char{$i})) % 256);
    }
    return base64_encode($str);
}

function decryptToken($data, $key='baizhikang')
{
    $char = '';
    $str = '';
    $key = md5($key);
    $x = 0;
    $data = base64_decode($data);
    $len = strlen($data);
    $l = strlen($key);
    for ($i = 0; $i < $len; $i++)
    {
        if ($x == $l) 
        {
         $x = 0;
        }
        $char .= substr($key, $x, 1);
        $x++;
    }
    for ($i = 0; $i < $len; $i++)
    {
        if (ord(substr($data, $i, 1)) < ord(substr($char, $i, 1)))
        {
            $str .= chr((ord(substr($data, $i, 1)) + 256) - ord(substr($char, $i, 1)));
        }
        else
        {
            $str .= chr(ord(substr($data, $i, 1)) - ord(substr($char, $i, 1)));
        }
    }
    return $str;
}

function checkToken($token, $time=true)
{
    $str = decryptToken($token);
    $data = explode(':', $str);
    if (count($data) != 2) {
        return false;
    }
    if ($time && $data[1] < time()) {
        return false;
    }
    if (!is_numeric($data[0]) || $data[0] <= 0) {
        return false;
    }
    return $data[0];
}

function generateToken($id, $time=7*60*60*24)
{
    $expireTime = time() + $time;
    $token = encryptToken($id . ':' . $expireTime);
    return $token;
}

