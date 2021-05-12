<?php

namespace Janfish\Auth;


/**
 * Author:Robert
 *
 * Interface AuthedInterface
 * @package App\Http\Security
 */
interface IdentityInterface
{


    public function login(array $data, string $type): AuthResult;


}
