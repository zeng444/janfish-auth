<?php

use Janfish\Auth\Auth;
use Janfish\Auth\AuthResult;
use Janfish\Auth\IdentityInterface;

class MyIdentity implements IdentityInterface
{

    public function login(array $data, string $type): AuthResult
    {
        $right = false;
        if ($type === Auth::JWT_TYPE) {
            $right = true;
        } elseif ($type === Auth::BASIC_TYPE) {
            if ($data['id'] === 'zeng444') {
                $right = true;
            }
        } else {
            $right = true;
        }
        $authResult = new AuthResult();
        if ($right) {
            $authResult->setIdentity($data['id']);
            $authResult->setExtendedData($data['ext']);
        }
        return $authResult;
    }
}