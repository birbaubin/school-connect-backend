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

$router->get('/', function () use ($router) {
    return $router->app->version();
});


$router->get('/hello', "ExampleController@hello");
$router->post('/add/student', "StudentController@addStudent");
$router->post('/update/student', "StudentController@updateStudent");
$router->get('/view/student/{studentId}', "StudentController@getStudentInfos");
$router->get('/get/student/all', "StudentController@getAllStudents");
$router->get('/search/student', "StudentController@searchStudent");
$router->get('/delete/student/{studentId}', "StudentController@deleteStudent");



$router->post("/add/message", "MessageController@addMessage");
$router->get("/get/messages/sent/{senderId}", "MessageController@getAllSentMessages");
$router->get("/get/messages/received/{recipientId}", "MessageController@getAllReceivedMessages");
$router->get("/get/messages/unread/{recipientId}", "MessageController@getUnreadMessages");




