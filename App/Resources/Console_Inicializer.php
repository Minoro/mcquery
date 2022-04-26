<?php
use App\Console\Commander;
require './App/Resources/Molds.php';

if (file_exists("./vendor")) {
    if(file_exists(".env") or file_exists("./App/cache/env.php")){
        require_once './vendor/autoload.php';   
        require_once './App/Helpers.php';
        date_default_timezone_set(env('TIMEZONE'));
        $action = false;
    }else{
        $action = true;
    }   
}else{
    $action = true;
}

if ($action == true) {
    echo "\033[1;31maplicação não iniciada, deseja criar o arquivo '.env' e instalar dependências ? (s/n)\033[0m ";
    $console = (string)readline("");
    readline_read_history();

    if ($console == 's') {
        $file = mold_env();
        file_put_contents('.env', $file);
        shell_exec('composer install');

        if (file_exists("README.md")) {
            unlink("README.md");
        }

        if (file_exists("LICENSE")) {
            unlink("LICENSE");
        }

        echo "\033[0;32maplicação iniciada com sucesso\033[0m" . PHP_EOL;
        die();
    } else {
        echo "\033[1;31moperação cancelada\033[0m" . PHP_EOL;
        die();
    }
} else {
    $console = new Commander;
    $console->commands();
}