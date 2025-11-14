<?php
declare(strict_types=1);

const APP_NAME = 'PHP Superglobals Demo';
date_default_timezone_set('Europe/Madrid');

// Toggle this to true during class to show errors on-screen for demo pages.
if (!headers_sent()) {
    ini_set('display_errors', '1');
    error_reporting(E_ALL);
}
