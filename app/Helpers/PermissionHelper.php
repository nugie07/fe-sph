<?php

namespace App\Helpers;

class PermissionHelper
{
    /**
     * Check if user has access to a specific permission
     */
    public static function hasPermission($permissionKey)
    {
        $permissions = session('permissions', []);

        // Check if permission exists and has value 1
        if (isset($permissions[$permissionKey]) && $permissions[$permissionKey] == 1) {
            return true;
        }

        // Check if permission exists as an object with _access
        if (isset($permissions[$permissionKey]) &&
            is_array($permissions[$permissionKey]) &&
            isset($permissions[$permissionKey]['_access']) &&
            $permissions[$permissionKey]['_access'] == 1) {
            return true;
        }

        return false;
    }

    /**
     * Check if user has access to a menu
     */
    public static function hasMenuAccess($menuKey)
    {
        return self::hasPermission($menuKey);
    }

    /**
     * Check if user has access to a submenu
     */
    public static function hasSubMenuAccess($menuKey, $subMenuKey = null)
    {
        $permissions = session('permissions', []);

        if (!isset($permissions[$menuKey])) {
            return false;
        }

        $menu = $permissions[$menuKey];

        // If menu doesn't have _access or _access is 0, return false
        if (!is_array($menu) || !isset($menu['_access']) || $menu['_access'] != 1) {
            return false;
        }

        // If no submenu specified, just check menu access
        if (!$subMenuKey) {
            return true;
        }

        // Check submenu access
        if (isset($menu['_sub_menus']) &&
            isset($menu['_sub_menus'][$subMenuKey]) &&
            isset($menu['_sub_menus'][$subMenuKey]['_access']) &&
            $menu['_sub_menus'][$subMenuKey]['_access'] == 1) {
            return true;
        }

        return false;
    }

    /**
     * Check if user has access to a specific action
     */
    public static function hasActionAccess($menuKey, $actionKey = null, $subMenuKey = null)
    {
        $permissions = session('permissions', []);

        if (!isset($permissions[$menuKey])) {
            return false;
        }

        $menu = $permissions[$menuKey];

        // If menu doesn't have _access or _access is 0, return false
        if (!is_array($menu) || !isset($menu['_access']) || $menu['_access'] != 1) {
            return false;
        }

        // If no action specified, just check menu access
        if (!$actionKey) {
            return true;
        }

        // Check action in main menu
        if (isset($menu['_actions']) && is_array($menu['_actions'])) {
            foreach ($menu['_actions'] as $action) {
                if (isset($action[$actionKey]) && $action[$actionKey] == 1) {
                    return true;
                }
            }
        }

        // Check action in submenu if specified
        if ($subMenuKey && isset($menu['_sub_menus']) &&
            isset($menu['_sub_menus'][$subMenuKey]) &&
            isset($menu['_sub_menus'][$subMenuKey]['_actions'])) {

            foreach ($menu['_sub_menus'][$subMenuKey]['_actions'] as $action) {
                if (isset($action[$actionKey]) && $action[$actionKey] == 1) {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Get all accessible menus for sidebar
     */
    public static function getAccessibleMenus()
    {
        $permissions = session('permissions', []);
        $accessibleMenus = [];

        foreach ($permissions as $key => $value) {
            if (self::hasMenuAccess($key)) {
                $accessibleMenus[$key] = $value;
            }
        }

        return $accessibleMenus;
    }
}
