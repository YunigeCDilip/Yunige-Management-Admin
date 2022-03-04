<?php

namespace App\Constants;

/**
 * Class MessageResponse
 *
 * Register all the messages here
 */
class MessageResponse
{
    const NOT_FOUND         = 'Data not found.';
    const DATA_FOUND        = 'Data found.';
    const DATA_LOADED       = 'Data loaded successfully.';
    const DATA_CREATED      = 'Data created successfully.';
    const DATA_UPDATED      = 'Data updated successfully.';
    const DATA_DELETED      = 'Data deleted successfully.';
    const NOT_DELETED       = 'Data not deleted. it is attached to other data.';
    const DEACTIVATED       = 'You have been deactivated as a user. Please contact your Admin.';
    const INVALID_LOGIN     = 'The email or password is invalid.';
    const LOGIN_SUCCESS     = 'Logged in successfully.';
    const SETTING_UPDATED   = 'Settings updated successfully.';
}
