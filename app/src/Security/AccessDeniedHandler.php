<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

/**
 * Class AccessDeniedHandler
 *
 * @package App\Security
 */
final class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    /**
     * @var \Symfony\Component\Routing\Generator\UrlGeneratorInterface
     */
    protected UrlGeneratorInterface $urlGenerator;

    /**
     * AccessDeniedHandler constructor.
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
    public function handle(Request $request, AccessDeniedException $accessDeniedException): RedirectResponse
    {
        $request->getSession()->getFlashBag()->add('note', 'You do not have the permission to access this content!');
        return new RedirectResponse($this->urlGenerator->generate('app_pages_access_denied'));
    }
}