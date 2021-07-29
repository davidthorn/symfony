<?php

namespace App\ViewModel;

use App\Interfaces\HomeViewModelInterface;
use App\Security\Roles;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class HomeViewModel
 *
 * @package App\ViewModel
 */
final class HomeViewModel implements HomeViewModelInterface
{
    /**
     * @var \Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface
     */
    protected AuthorizationCheckerInterface $authorizationChecker;

    /**
     * HomeViewModel constructor.
     *
     * @param \Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface $authorizationChecker
     */
    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @return string
     */
    public function getLoginButtonText(): string {
        return $this->isAuthenticated() == false ? self::LOGIN_TEXT : self::LOGOUT_TEXT;
    }

    /**
     * @inheritDoc
     *
     * @return bool
     */
    public function isAdmin(): bool
    {
        return $this->authorizationChecker->isGranted(Roles::ADMIN);
    }

    /**
     * @inheritDoc
     *
     * @return bool
     */
    public function isAuthenticated(): bool
    {
        return $this->authorizationChecker->isGranted(Roles::USER);
    }
}