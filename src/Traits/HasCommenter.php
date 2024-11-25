<?php

namespace Balajidharma\LaravelComment\Traits;

use Illuminate\Support\Facades\Config;

/**
 * Add this trait to your User model so
 * that you can retrieve the comments for a user.
 */
trait HasCommenter
{
    /**
     * Returns all comments that this user has made.
     */
    public function comments()
    {
        return $this->morphMany(Config::get('comment.models.comment'), 'commenter');
    }

    /**
     * Returns only approved comments that this user has made.
     */
    public function approvedComments()
    {
        return $this->morphMany(Config::get('comment.models.comment'), 'commenter')->where('status', Config::get('comment.status.approved'));
    }

    /**
     * Returns only pending comments that this user has made.
     */
    public function pendingComments()
    {
        return $this->morphMany(Config::get('comment.models.comment'), 'commenter')->where('status', Config::get('comment.status.pending'));
    }

    /**
     * Returns only rejected comments that this user has made.
     */
    public function rejectedComments()
    {
        return $this->morphMany(Config::get('comment.models.comment'), 'commenter')->where('status', Config::get('comment.status.rejected'));
    }
}