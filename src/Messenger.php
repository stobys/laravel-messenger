<?php

namespace SylveK\LaravelMessenger;

class Messenger
{
    /**
     * Map for the messenger's models.
     *
     * @var array
     */
    protected $models = [];

    /**
     * Map for the messenger's tables.
     *
     * @var array
     */
    protected $tables = [];

    /**
     * Internal pointer name for the app's "user" model.
     *
     * @var string
     */
    private $userModelLookupKey = 'User';

    /**
     * Set the model to be used for threads.
     *
     * @param string $model
     */
    public function setMessageModel($model)
    {
        $this -> models[Message::class] = $model;
    }

    /**
     * Set the model to be used for participants.
     *
     * @param  string $model
     */
    public function setParticipantModel($model)
    {
        $this -> models[Participant::class] = $model;
    }

    /**
     * Set the model to be used for threads.
     *
     * @param  string $model
     */
    public function setThreadModel($model)
    {
        $this -> models[Thread::class] = $model;
    }

    /**
     * Set the model to be used for users.
     *
     * @param  string  $model
     */
    public function setUserModel($model)
    {
        $this -> models[$this -> userModelLookupKey] = $model;
    }

    /**
     * Set custom table names.
     *
     * @param  array $map
     */
    public function setTables(array $map)
    {
        $this -> tables = array_merge($this -> tables, $map);
    }

    /**
     * Get a custom table name mapping for the given table.
     *
     * @param  string $table
     * @return string
     */
    public function table($table)
    {
        return $this -> tables[$table] ?? $table;
    }

    /**
     * Get the class name mapping for the given model.
     *
     * @param  string $model
     * @return string
     */
    public function classname($model)
    {
        return $this -> models[$model] ?? $model;
    }

    /**
     * Get an instance of the messages model.
     *
     * @param  array $attributes
     * @return \Cmgmyr\Messenger\Models\Message
     */
    public function message(array $attributes = [])
    {
        return $this -> make(Message::class, $attributes);
    }

    /**
     * Get an instance of the participants model.
     *
     * @param  array $attributes
     * @return \Cmgmyr\Messenger\Models\Participant
     */
    public function participant(array $attributes = [])
    {
        return $this -> make(Participant::class, $attributes);
    }

    /**
     * Get an instance of the threads model.
     *
     * @param  array $attributes
     * @return \Cmgmyr\Messenger\Models\Thread
     */
    public function thread(array $attributes = [])
    {
        return $this -> make(Thread::class, $attributes);
    }

    /**
     * Get an instance of the user model.
     *
     * @param  array  $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function user(array $attributes = [])
    {
        return $this -> make($this -> userModelLookupKey, $attributes);
    }

    /**
     * Get an instance of the given model.
     *
     * @param  string $model
     * @param  array $attributes
     * @return \Illuminate\Database\Eloquent\Model
     */
    protected function make($model, array $attributes = [])
    {
        $model = $this -> classname($model);

        return new $model($attributes);
    }
}
