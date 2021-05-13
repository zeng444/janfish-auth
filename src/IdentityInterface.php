<?php

namespace Janfish\Auth;


/**
 * Interface IdentityInterface
 * @package Janfish\Auth
 */
interface IdentityInterface
{


    public function authenticate(array $data, string $type): AuthResult;


}
