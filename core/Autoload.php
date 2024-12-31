<?php

// Load environment and core files
require_once __DIR__ . '/../core/Database.php';
require_once __DIR__ . '/../core/Controller.php';
require_once __DIR__ . '/../core/Model.php';
require_once __DIR__ . '/../core/Router.php';

// Autoload for models and controllers
spl_autoload_register(function ($className) {
    $paths = [
        'app/controllers/',
        'app/models/',
        'core/',
    ];
    foreach ($paths as $path) {
        $file = __DIR__ . "/../{$path}{$className}.php";
        // echo "Mencoba load: {$file}<br>"; // Debugging
        if (file_exists($file)) {
            require_once $file;
            // echo "Berhasil load: {$file}<br>"; // Debugging
            return;
        }
    }
    die("File untuk kelas {$className} tidak ditemukan.");
});
