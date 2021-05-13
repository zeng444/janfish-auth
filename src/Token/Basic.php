<?php

namespace Janfish\Auth\Token;

/**
 * Class Basic
 * @package Janfish\Auth\Token
 */
class Basic implements TokenInterface
{


    /**
     * Author:Robert
     *
     * @param array $options
     */
    public function setOptions(array $options): void
    {

    }

    /**
     * Author:Robert
     *
     * @param array $data
     * @param int $expire
     * @return string
     */
    public function generateToken(array $data, int $expire): string
    {
        return base64_encode($data['id'] . ':' . $data['ext']);
    }

    /**
     * Author:Robert
     *
     * @param string $token
     * @return array
     */
    public function parseToken(string $token): array
    {
        $token = base64_decode($token);
        if (!preg_match('/([^:]+):([^:]+)/', $token, $matched)) {
            return [];
        }
        return [
            'id' => $matched[1],
            'ext' => $matched[2],
        ];

    }
}
