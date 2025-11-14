<?php
declare(strict_types=1);

function h(string $s): string {
    return htmlspecialchars($s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function dump_var($var): void {
    echo '<pre style="background:#111;color:#0f0;padding:12px;overflow:auto;">';
    var_dump($var);
    echo '</pre>';
}

function nav(): void {
    $links = [
        'Home' => '/index.php',
        '$_GET' => '/demos/get.php',
        '$_POST' => '/demos/post.php',
        '$_FILES' => '/demos/files.php',
        '$_COOKIE' => '/demos/cookie.php',
        '$_SESSION' => '/demos/session_start.php',
        '$_REQUEST' => '/demos/request.php',
        '$_SERVER' => '/demos/server.php',
        '$GLOBALS' => '/demos/globals.php',
        'phpinfo()' => '/demos/phpinfo.php',
        'php.ini (ini_set)' => '/demos/ini.php',
        'include / require' => '/demos/include_require.php',
        'include_once' => '/demos/include_once.php',
    ];
    echo '<nav style="margin:1rem 0">';
    foreach ($links as $label => $href) {
        printf('<a href="%s" style="margin-right:12px">%s</a>', h($href), h($label));
    }
    echo '</nav>';
}
