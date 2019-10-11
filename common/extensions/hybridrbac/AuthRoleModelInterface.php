<?php
/**
 * This file is part of the elisdn/yii2-hybrid-authmanager library
 *
 * @copyright Copyright (c) Dmitriy Yeliseyev <mail@elisdn.ru>
 * @license https://github.com/ElisDN/yii2-hybrid-authmanager/blob/master/LICENSE.md
 * @link https://github.com/ElisDN/yii2-hybrid-authmanager
 */

namespace allcho\rbac\common\extensions\hybridrbac;

interface AuthRoleModelInterface
{
    /**
     * @param mixed $id
     * @return AuthRoleModelInterface
     */
    public static function findAuthRoleIdentity($id);

    /**
     * @param string $roleName
     * @return array
     */
    public static function findAuthIdsByRoleName($roleName);

    /**
     * @return array
     */
    public function getAuthRoleNames();

    /**
     * @param string $roleName
     */
    public function addAuthRoleName($roleName);

    /**
     * @param string $roleName
     */
    public function removeAuthRoleName($roleName);

    /**
     * Removes all roles
     */
    public function clearAuthRoleNames();
}