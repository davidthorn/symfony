<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Http\EntryPoint\AuthenticationEntryPointInterface;

/**
 * Class AuthenticationEntryPoint
 *
 * @package App\Security
 */
final class AuthenticationEntryPoint implements AuthenticationEntryPointInterface
{
    /**
     * @var \Symfony\Component\Routing\Generator\UrlGeneratorInterface
     */
    protected UrlGeneratorInterface $urlGenerator;

    /**
     * AuthenticationEntryPoint constructor.
     *
     * @param \Symfony\Component\Routing\Generator\UrlGeneratorInterface $urlGenerator
     */
    public function __construct(UrlGeneratorInterface $urlGenerator)
    {
        $this->urlGenerator = $urlGenerator;
    }

    /**
     * @inheritDoc
     */
    public function start(Request $request, AuthenticationException $authException = null): RedirectResponse|Response
    {
        $request->getSession()->getFlashBag()->add('note', 'You have to login in order to access this page.');
        return new RedirectResponse($this->urlGenerator->generate('app_auth_login'));
    }
}