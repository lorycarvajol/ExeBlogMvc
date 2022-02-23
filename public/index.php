<?php

// autoload

require '../vendor/autoload';

//activé le debug mode
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();


//démarer altorouteur
$router = new Altorouter();

//mappé les routes 

$router->map('GET', '/', 'index', 'index');
$router->map('GET', '/contact', 'contact', 'contact');
$router->map('GET', '/404', '404', '404');

//matché les routes

$match = $router->match();

if( is_array($match)) {
      
   if( is_callable( $match['target'] ) ) {
      call_user_func_array( $match['target'], $match['params']);
   }else{
      $params = $match['params'];
      include "../app/views/{$target}.view.php";
   }
}else {
   include "../app/views/404.view.php";
}


