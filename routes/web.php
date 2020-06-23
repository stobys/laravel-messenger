<?php

// -- ROUTE PATTERN
Route::pattern('thread', '[0-9]+');
Route::pattern('message', '[0-9]+');

// -- ROUTE MODEL BINDING
Route::bind('thread', function ($value) {
    return SylveK\LaravelMessenger\Models\Thread::withTrashed() -> where('id', $value) -> first();
});

Route::bind('message', function ($value) {
    return SylveK\LaravelMessenger\Models\Message::withTrashed() -> where('id', $value) -> first();
});

// -- ROUTING GROUP
Route::group(['prefix' => 'messages', 'middleware' => 'web'], function () {

    Route::get('/', '\SylveK\LaravelMessenger\Controllers\MessengerController@index') -> name('messenger-index');

});
