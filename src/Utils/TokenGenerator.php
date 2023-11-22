<?php

namespace App\Utils ;
use App\Entity\User;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;

class TokenGenerator
{
    private JWTTokenManagerInterface $jwtTokenManager;

    public function __construct(JWTTokenManagerInterface $jwtTokenManager)
    {
        $this->jwtTokenManager = $jwtTokenManager;
    }

    public function generateToken(User $user): String
    {
        return $this->jwtTokenManager->create($user);
    }
}
