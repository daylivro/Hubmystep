<?php

namespace App\Enums;

use Essa\APIToolKit\Enum\Enum;

class PermissionEnum extends Enum
{
    const CREATE_USER = 'create_user';
    const UPDATE_USER = 'update_user';
    const DELETE_USER = 'delete_user';
    const VIEW_USER = 'view_user';

    const CREATE_ROLE = 'create_role';
    const UPDATE_ROLE = 'update_role';
    const DELETE_ROLE = 'delete_role';
    const VIEW_ROLE = 'view_role';

    const CREATE_PERMISSION = 'create_permission';
    const UPDATE_PERMISSION = 'update_permission';
    const DELETE_PERMISSION = 'delete_permission';
    const VIEW_PERMISSION = 'view_permission';

    const CREATE_FAQ = 'create_faq';
    const UPDATE_FAQ = 'update_faq';
    const DELETE_FAQ = 'delete_faq';
    const VIEW_FAQ = 'view_faq';

    const CREATE_PARTNER_CATEGORY = 'create_partner_category';
    const UPDATE_PARTNER_CATEGORY = 'update_partner_category';
    const DELETE_PARTNER_CATEGORY = 'delete_partner_category';
    const VIEW_PARTNER_CATEGORY = 'view_partner_category';

    const CREATE_PARTNER = 'create_partner';
    const UPDATE_PARTNER = 'update_partner';
    const DELETE_PARTNER = 'delete_partner';
    const VIEW_PARTNER = 'view_partner';
}
