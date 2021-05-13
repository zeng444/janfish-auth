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

    /**
     * @var
     */
    private $_identity;

    /**
     * @var
     */
    private $_extendedData;

    /**
     * @var
     */
    private $_failType;

    /**
     * @return mixed
     */
    public function getExtendedData()
    {
        return $this->_extendedData;
    }

    /**
     * @param $data
     */
    public function setExtendedData($data)
    {
        $this->_extendedData = $data;
    }

    /**
     * @return string
     */
    public function getIdentity(): string
    {
        return $this->_identity;
    }

    /**
     * @param string $id
     */
    public function setIdentity(string $id)
    {
        $this->_identity = $id;
    }

    /**
     * @return bool
     */
    public function isIdentity(): bool
    {
        return !!$this->_identity;
    }

}