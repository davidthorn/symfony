<?php

namespace App\Interfaces;

use App\Security\Roles;
use App\ViewModel\HomeViewModel;

/**
 * Interface HomeViewModelInterface
 *
 * @package App\Interfaces
 */
interface HomeViewModelInterface
{
    /**
     * Text used for the login button
     */
    public const LOGIN_TEXT = 'Login';

    /**
     * Text used for the logout button
     */
    public const LOGOUT_TEXT = 'Logout';

    /**
     * Returns the text for the login button based upon if the user is authenticated.
     *
     * @return string
     */
    public function getLoginButtonText(): string;

    /**
     * Returns true if the user has the Roles::ADMIN role.
     *
     * @return bool
     */
    public function isAdmin(): bool;

    /**
     * Returns true if the current user has the Roles::USER role.
     *
     * @return bool
     */
    public function isAuthenticated(): bool;
}