<?php

$app->post('/login', '\App\Controllers\UserController:login');


$app->get('/api/contacts', '\App\Controllers\ContactController:listAll');

$app->get('/api/contacts/{id}', '\App\Controllers\ContactController:list');

$app->post('/api/contacts', '\App\Controllers\ContactController:create');

$app->put('/api/contacts/{id}', '\App\Controllers\ContactController:update');

$app->delete('/api/contacts/{id}', '\App\Controllers\ContactController:remove');
