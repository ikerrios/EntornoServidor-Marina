<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/functions.php';
?><!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= h(APP_NAME) ?></title>
  <style>
    :root { color-scheme: light dark; }
    body { font-family: system-ui, -apple-system, Segoe UI, Roboto, Ubuntu, Cantarell, 'Helvetica Neue', Arial, 'Noto Sans', 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol'; margin: 2rem; line-height: 1.5; }
    code, pre { font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, 'Liberation Mono', 'Courier New', monospace; font-size: .95em; }
    a { text-decoration: none; }
    a:hover { text-decoration: underline; }
    .card { border: 1px solid #ccc; border-radius: 12px; padding: 1rem; margin: 1rem 0; }
    .ok { background: #e6ffed; border-color: #8aff9b; }
    .warn { background: #fff5e6; border-color: #ffc266; }
    .err { background: #ffe6e6; border-color: #ff8080; }
    table { border-collapse: collapse; width: 100%; }
    th, td { border: 1px solid #ddd; padding: .5rem; text-align: left; }
    th { background: #f3f3f3; }
  </style>
</head>
<body>
<header>
  <h1><?= h(APP_NAME) ?></h1>
  <?php nav(); ?>
  <hr>
</header>
<main>
