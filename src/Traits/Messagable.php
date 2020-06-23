<?php

namespace SylveK\LaravelMessenger\Traits;

use Illuminate\Database\Eloquent\Builder;

use SylveK\LaravelMessenger\Helpers\Models;
use SylveK\LaravelMessenger\Models\Message;
use SylveK\LaravelMessenger\Models\Participant;
use SylveK\LaravelMessenger\Models\Thread;

trait Messagable
{
    /**
     * Message relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     * @codeCoverageIgnore
     */
    public function messages()
    {
        return $this -> hasMany( Message::class );
    }

    /**
     * Participants relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     *
     * @codeCoverageIgnore
     */
    public function participants()
    {
        return $this->hasMany(Models::classname(Participant::class));
    }

    /**
     * Thread relationship.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     *
     * @codeCoverageIgnore
     */
    public function threads()
    {
        return $this->belongsToMany(
            Models::classname(Thread::class),
            Models::table('participants'),
            'user_id',
            'thread_id'
        );
    }

    /**
     * Returns the new messages count for user.
     *
     * @return int
     */
    public function newThreadsCount()
    {
        return $this->threadsWithNewMessages()->count();
    }

    /**
     * Returns the new messages count for user.
     *
     * @return int
     */
    public function unreadMessagesCount()
    {
        return Message::unreadForUser($this->getKey())->count();
    }

    /**
     * Returns all threads with new messages.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function threadsWithNewMessages()
    {
        return $this->threads()
            ->where(function (Builder $q) {
                $q->whereNull(Models::table('participants') . '.last_read');
                $q->orWhere(Models::table('threads') . '.updated_at', '>', $this->getConnection()->raw($this->getConnection()->getTablePrefix() . Models::table('participants') . '.last_read'));
            })->get();
    }
}
