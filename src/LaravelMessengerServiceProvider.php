<?php

namespace SylveK\LaravelMessenger;

use Illuminate\Support\ServiceProvider;

// use Cmgmyr\Messenger\Models\Message;
// use Cmgmyr\Messenger\Models\Models;
// use Cmgmyr\Messenger\Models\Participant;
// use Cmgmyr\Messenger\Models\Thread;

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

        Models::setMessageModel($config->get('messenger.message_model', Message::class));
        Models::setThreadModel($config->get('messenger.thread_model', Thread::class));
        Models::setParticipantModel($config->get('messenger.participant_model', Participant::class));

        Models::setTables([
            'messages' => $config->get('messenger.messages_table', Models::message()->getTable()),
            'participants' => $config->get('messenger.participants_table', Models::participant()->getTable()),
            'threads' => $config->get('messenger.threads_table', Models::thread()->getTable()),
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

        Models::setUserModel($model);

        Models::setTables([
            'users' => (new $model)->getTable(),
        ]);
    }
}
