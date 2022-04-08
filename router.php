<?php
require 'App/bootstrap.php';
use Controllers\{ErrorController, HomeController, SitemapController};

// -------------------------------------------------------------------------

$route->url('/', function(){
    (new HomeController)->render();
})->name('home');

// sitemap dinamico 'pode ser removido caso não seja necessário'
$route->url('/sitemap.xml', function(){
    (new SitemapController)->sitemap();
})->name('sitemap');

















// a pagina de erro deve ter o nome error para q o 'mcquery' reconheça
// a url pode ser alterada
$route->url('/error', function(){(new ErrorController)->render();})->name('error');

// -------------------------------------------------------------------------

$route->end();