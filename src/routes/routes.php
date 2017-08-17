<?php

Route::get('gamers', 'Losepay\Http\Controller\Controller@getGamers');
Route::get('gamers/{id}', 'Losepay\Http\Controller\Controller@getGamerById');