<?php

return [
    // -- Models informations
    'models'   => [
        'user'  => [
            'table' => 'users',
            'model' => App\Models\User::class,
        ],
    	'threads'	=> [
    		'table'	=> 'threads',
    		'model'	=> SylveK\LaravelMessenger\Models\Thread::class,
    	],
    	'messages'	=> [
    		'table'	=> 'messages',
    		'model'	=> SylveK\LaravelMessenger\Models\Message::class,
    	],
    	'thread_members'	=> [
    		'table'	=> '',
    		'model'	=> SylveK\LaravelMessenger\Models\Participant::class,
    	],

    ],

];
