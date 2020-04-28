<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

/* AC */
$router->get('/', function () use ($router) {
    //return $router->app->version();
	echo "Hello, this is Library IT :-)";
	
	
	//AC return phpinfo();
});

//$router->get("/list","ACController@listtitles");
$router->get("/list","TitleListController@listtitles");

$router->get("/titles", "TitleListController@getTitleList");

$router->get("/titles/{data}", "TitleListController@getTitles");

$router->get("/ttitles/", "TitleListController@getTitles");


$router->get("/myapi","TitleListController@myfirstapi");

