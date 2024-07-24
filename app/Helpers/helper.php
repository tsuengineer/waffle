<?php

if (!function_exists('user_directory_path')) {
    function user_directory_path($user_id): string
    {
        $userIdStr = str_pad($user_id, 9, '0', STR_PAD_LEFT);
        $pathParts = str_split($userIdStr, 3);
        return implode('/', $pathParts);
    }
}
