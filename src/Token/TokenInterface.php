<?php

namespace Janfish\Auth\Token;

interface TokenInterface
{

    public function generateToken(array $data, int $expire): string;

    public function setOptions(array $options): void;

    public function parseToken(string $token): array;

}
