<?php
namespace App\Console;

use App\Console;
use App\Console\Commands\Command_Autoload;
use App\Console\Commands\Command_Cache;
use App\Console\Commands\Command_Conexao;
use App\Console\Commands\Command_Controller;
use App\Console\Commands\Command_Database;
use App\Console\Commands\Command_Drop;
use App\Console\Commands\Command_Env;
use App\Console\Commands\Command_Install;
use App\Console\Commands\Command_List;
use App\Console\Commands\Command_Migrate;
use App\Console\Commands\Command_Model;
use App\Console\Commands\Command_Server;

class Commander
{
    private $headline;
    private $console;

    public function __construct()
    {
        $this->console = new Console;
        $this->headline = $this->console->headline;
    }

    public function commands()
    {
        $this->console->command('server', function () {
            (new Command_Server)->server();
        });

        $this->console->command('server --port', function () {
            (new Command_Server)->port($this->headline);
        });

        $this->console->command('controllers', function () {
            (new Command_Controller)->controller($this->headline);
        });

        $this->console->command('install', function () {
            (new Command_Install)->install();
        });

        $this->console->command('autoload', function () {
            (new Command_Autoload)->autoload();
        });

        $this->console->command('conexao', function () {
            (new Command_Conexao)->conexao();
        });

        $this->console->command('env', function () {
            (new Command_Env)->env();
        });

        $this->console->command('cache', function () {
            switch ($this->headline):
                case "env":
                    (new Command_Cache)->cache_env();
                    break;
                default:
                    $this->command_end();
                    break;
            endswitch;
        });

        // commands data base
        $this->console->command('model', function () {
            (new Command_Model)->model($this->headline);
        });

        $this->console->command('database', function () {
            (new Command_Database)->database($this->headline);
        });

        $this->console->command('migrate', function () {
            (new Command_Migrate)->migrate();
        });

        $this->console->command('drop', function () {
            (new Command_Drop)->drop_table($this->headline);
        });

        $this->console->command('list', function () {
            switch ($this->headline):
                case "migrations":
                    (new Command_List)->list_migrations();
                    break;
                default:
                    $this->command_end();
                    break;
            endswitch;
        });

        $this->command_end();
    }

    private function command_end()
    {
        die("\033[1;31mcomando inválido\033[0m" . PHP_EOL);
    }
}