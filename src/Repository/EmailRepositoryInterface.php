<?php

declare(strict_types=1);

namespace ShieldW4ll\SimpleAuthenticator\Repository;

use Symfony\Component\Security\Core\User\UserInterface;

interface EmailRepositoryInterface
{
    public function findOneByEmail(string $email): UserInterface;
}