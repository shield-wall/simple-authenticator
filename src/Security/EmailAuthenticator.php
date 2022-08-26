<?php

declare(strict_types=1);

namespace ShieldWall\SimpleAuthenticator\Security;

use ShieldWall\SimpleAuthenticator\Repository\EmailRepositoryInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Symfony\Component\Security\Http\Authenticator\Passport\SelfValidatingPassport;

final class EmailAuthenticator extends AbstractAuthenticator
{
    private const LOGIN_ROUTE = 'simple_authenticator_login';

    public function __construct(
        private readonly UrlGeneratorInterface $urlGenerator,
        private readonly EmailRepositoryInterface $emailRepository,
        private readonly string $simpleAuthenticatorRouteSuccess,
        private readonly string $simpleAuthenticatorRouteFailure,
    ) {}

    public function supports(Request $request): ?bool
    {
        return self::LOGIN_ROUTE === $request->attributes->get('_route')
            && $request->isMethod(Request::METHOD_POST);
    }

    public function authenticate(Request $request): Passport
    {
        ['email' => $email] = $request->get('simple_authenticator');

        return new SelfValidatingPassport(new UserBadge(
            $email,
            fn($email) => $this->emailRepository->findOneByEmail($email)
        ));
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName): ?Response
    {
        return new RedirectResponse($this->urlGenerator->generate($this->simpleAuthenticatorRouteSuccess));
    }

    public function onAuthenticationFailure(Request $request, AuthenticationException $exception): ?Response
    {
        return new RedirectResponse($this->urlGenerator->generate($this->simpleAuthenticatorRouteFailure));
    }
}