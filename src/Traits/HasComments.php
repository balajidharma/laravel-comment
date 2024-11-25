<?php

namespace Balajidharma\LaravelComment\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Config;

trait HasComments
{
    public function comments(): MorphMany
    {
        return $this->morphMany(Config::get('comment.models.comment'), 'commentable');
    }

    /**
     * Returns only approved comments that this user has made.
     */
    public function approvedComments()
    {
        return $this->morphMany(Config::get('comment.models.comment'), 'commentable')->where('status', Config::get('comment.status.approved'));
    }

    /**
     * Returns only pending comments that this user has made.
     */
    public function pendingComments()
    {
        return $this->morphMany(Config::get('comment.models.comment'), 'commentable')->where('status', Config::get('comment.status.pending'));
    }

    /**
     * Returns only rejected comments that this user has made.
     */
    public function rejectedComments()
    {
        return $this->morphMany(Config::get('comment.models.comment'), 'commentable')->where('status', Config::get('comment.status.rejected'));
    }
}