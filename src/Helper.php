<?php 

if (!function_exists('package_assets')) {
    function package_asset($path)
    {
        return asset('vendor/categorizable/'.$path);
    }
}