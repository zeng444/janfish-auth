<?php

namespace Janfish\Auth;

/**
 * Author:Robert
 *
 * Class Auth
 * @package Janfish\Auth
 */
class AuthResult
{

    private $_identity;
    private $_extendedData;

    public function setExtendedData($data)
    {
        $this->_extendedData = $data;
    }

    public function setIdentity(string $id)
    {
        $this->_identity = $id;
    }

    public function getExtendedData()
    {
        return $this->_extendedData;
    }

    public function getIdentity(): string
    {
        return $this->_identity;
    }

    public function isIdentity(): bool
    {
        return !!$this->_identity;
    }
}