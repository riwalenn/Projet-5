<?php


class UserHelper
{
    public function generateToken($length = 32)
    {
        $token = random_bytes($length);
        return bin2hex($token);
    }
}