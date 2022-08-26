<?php

declare(strict_types=1);

namespace ShieldWall\SimpleAuthenticator\Repository;

use Symfony\Component\Security\Core\User\UserInterface;

interface EmailRepositoryInterface
{
    public function findOneByEmail(string $email): UserInterface;
}