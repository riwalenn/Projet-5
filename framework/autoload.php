<?php


function autoload($classname)
{
    $folders = ['src/model/', 'src/security/', 'src/entity/', 'framework/', 'src/controller/', 'migrations/'];

    foreach ($folders as $folder) {
        $classpath = $folder . $classname . '.php';

        if (file_exists($classpath)) {
            require $classpath;
        }

    }
}

spl_autoload_register('autoload');
