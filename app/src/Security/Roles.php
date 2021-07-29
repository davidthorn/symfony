<?php

namespace App\Security;

/**
 * Class Roles
 *
 * @package App\Security
 */
final class Roles
{

    /**
     * The user should be able to access the admin area, but not all areas.
     */
    public const ADMIN = 'ROLE_ADMIN';

    /**
     * The user can access everywhere within the admin area.
     */
    public const SUPER_ADMIN = 'ROLE_SUPER_ADMIN';

}