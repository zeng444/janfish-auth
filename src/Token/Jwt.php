<?php

namespace Janfish\Auth\Token;

use Firebase\JWT\ExpiredException;

/**
 * Class Jwt
 * @package Janfish\Auth\Token
 */
class Jwt implements TokenInterface
{

    const DEFAULT_JWT_ALG = 'HS256';
    const DEFAULT_ISS = 'Jwt Auth';

    /**
     * @var
     */
    private $_alg;

    /**
     * @var
     */
    private $_secret;

    /**
     * @var
     */
    private $_iss;

    /**
     * Author:Robert
     *
     * @param array $options
     * @throws \Exception
     */
    public function setOptions(array $options): void
    {
        if (!isset($options['secret']) || !$options['secret']) {
            throw new \Exception('算法错误');
        }
        $this->_iss = $options['iss'] ?? self::DEFAULT_ISS;
        $this->_alg = $options['alg'] ?? self::DEFAULT_JWT_ALG;
        $this->_secret = $options['secret'];
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
        $expire = time() + $expire;
        try {
            $token = [
                'iss' => $this->_iss,
                'iat' => time(),
                'exp' => $expire,
                'data' => $data,
            ];
            return \Firebase\JWT\JWT::encode($token, $this->_secret, $this->_alg);
        } catch (\Exception $exception) {
            return '';
        }
    }

    /**
     * @param string $token
     * @return array
     * @throws \Janfish\Auth\Exception\ExpiredException
     * @throws \Janfish\Auth\Exception\SignatureInvalidException
     */
    public function parseToken(string $token): array
    {
        try {
            $payload = \Firebase\JWT\JWT::decode($token, $this->_secret, [$this->_alg]);
            if (!$payload || !isset($payload->data)) {
                return [];
            }
            return $this->object2array($payload->data);
        } catch (ExpiredException $e) {
            throw new \Janfish\Auth\Exception\ExpiredException('Expired token');
        } catch (\Exception $e){
            throw new \Janfish\Auth\Exception\SignatureInvalidException('Signature verification failed');
        }
    }

    /**
     * Author:Robert
     *
     * @param $array
     * @return array
     */
    private function object2array($array)
    {
        if (is_object($array)) {
            $array = (array)$array;
        }
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                $array[$key] = $this->object2array($value);
            }
        }
        return $array;
    }
}
