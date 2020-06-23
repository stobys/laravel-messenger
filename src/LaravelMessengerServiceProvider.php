<?php

namespace SylveK\LaravelMessenger;

use Illuminate\Support\ServiceProvider;

// use SylveK\LaravelMessenger\Models\Message;
// use SylveK\LaravelMessenger\Models\Models;
// use SylveK\LaravelMessenger\Models\Participant;
// use SylveK\LaravelMessenger\Models\Thread;

use SylveK\LaravelMessenger\Facades\Messenger as Messaging;

class LaravelMessengerServiceProvider extends ServiceProvider
{
    // -- Bootstrap the application services.
    public function boot()
    {
        $this -> loadRoutesFrom(__DIR__ .'/../routes/web.php');

        $this -> registerPublishables();
        $this -> setMessengerModels();
        $this -> setUserModel();
    }

    // -- Register the application services.
    public function register()
    {
        $this->mergeConfigFrom(
            base_path('vendor/stobys/laravel-messenger/config/messenger.php'),
            'messenger-config'
        );

        $this -> loadViewsFrom(__DIR__.'/../resources/views', 'messenger');

        $this -> app -> bind('calculator', function($app) {
            return new Messenger();
        });

    }

    // -- Setup the resource publishing groups for Messenger.
    protected function registerPublishables()
    {
        if ($this->app->runningInConsole()) {
            $this -> publishes([
                base_path('vendor/stobys/laravel-messenger/config/messenger.php') => config_path('messenger.php'),
            ], 'config');

            $this -> publishes([
                base_path('vendor/stobys/laravel-messenger/database/migrations') => database_path('migrations'),
            ], 'migrations');
        }
    }

    // -- Define Messenger's models in registry.
    protected function setMessengerModels()
    {
        $config = $this->app->make('config');

        Messaging::setMessageModel($config->get('messenger.message_model', Message::class));
        Messaging::setThreadModel($config->get('messenger.thread_model', Thread::class));
        Messaging::setParticipantModel($config->get('messenger.participant_model', Participant::class));

        Messaging::setTables([
            'messages' => $config->get('messenger.messages_table', Messaging::message()->getTable()),
            'participants' => $config->get('messenger.participants_table', Messaging::participant()->getTable()),
            'threads' => $config->get('messenger.threads_table', Messaging::thread()->getTable()),
        ]);
    }

    /**
     * Define User model in Messenger's model registry.
     *
     * @return void
     */
    protected function setUserModel()
    {
        $config = $this->app->make('config');

        $model = $config->get('messenger.user_model', function () use ($config) {
            return $config->get('auth.providers.users.model', $config->get('auth.model'));
        });

        Messaging::setUserModel($model);

        Messaging::setTables([
            'users' => (new $model)->getTable(),
        ]);
    }
}
