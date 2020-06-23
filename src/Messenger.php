<?php

namespace SylveK\LaravelMessenger;

use SylveK\LaravelMessenger\Models\Thread;
use SylveK\LaravelMessenger\Models\Message;
use SylveK\LaravelMessenger\Models\Participant;

class Messenger
{
    // -- Map for the messenger's models.
    protected $models = [];

    // -- Map for the messenger's tables.
    protected $tables = [];

    // -- Internal pointer name for the app's "user" model.
    private $userModelLookupKey = 'User';

    // -- Set the model to be used for threads.
    public function setMessageModel($model)
    {
        $this -> models[Message::class] = $model;
    }

    // -- Set the model to be used for participants.
    public function setParticipantModel($model)
    {
        $this -> models[Participant::class] = $model;
    }

    // -- Set the model to be used for threads.
    public function setThreadModel($model)
    {
        $this -> models[Thread::class] = $model;
    }

    // -- Set the model to be used for users.
    public function setUserModel($model)
    {
        $this -> models[$this -> userModelLookupKey] = $model;
    }

    // -- Set custom table names.
    public function setTables(array $map)
    {
        $this -> tables = array_merge($this -> tables, $map);
    }

    // -- Get a custom table name mapping for the given table.
    public function table($table)
    {
        return $this -> tables[$table] ?? $table;
    }

    // -- Get the class name mapping for the given model.
    public function classname($model)
    {
        return $this -> models[$model] ?? $model;
    }

    // -- Get an instance of the messages model.
    public function message(array $attributes = [])
    {
        return $this -> make(Message::class, $attributes);
    }

    // -- Get an instance of the participants model.
    public function participant(array $attributes = [])
    {
        return $this -> make(Participant::class, $attributes);
    }

    // -- Get an instance of the threads model.
    public function thread(array $attributes = [])
    {
        return $this -> make(Thread::class, $attributes);
    }

    // -- Get an instance of the user model.
    public function user(array $attributes = [])
    {
        return $this -> make($this -> userModelLookupKey, $attributes);
    }

    // -- Get an instance of the given model.
    protected function make($model, array $attributes = [])
    {
        $model = $this -> classname($model);

        return new $model($attributes);
    }
}
