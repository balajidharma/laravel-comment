<?php

namespace BalajiDharma\LaravelComment\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Config;
use BalajiDharma\LaravelComment\Exceptions\CommentException;

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

    /**
     * Get user model.
     */
    private function getUser($user = null)
    {
        if (! $user && auth()->check()) {
            return auth()->user();
        }

        if (! $user) {
            throw CommentException::invalidUser();
        }

        return $user;
    }

    /**
     * Add a comment as the currently authenticated user.
     *
     * @param  string   $content
     * @param  Model|null $user
     * @param  int|null $parentId
     * @param  int|null $replyToId
     * @return Model
     */
    public function comment(string $content, $user = null, ?int $parentId = null, ?int $replyToId = null): Model
    {
        $user = $this->getUser($user);

        return $this->comments()->create([
            'content'          => $content,
            'commenter_type'   => $user->getMorphClass(),
            'commenter_id'     => $user->getKey(),
            'commentable_type' => $this->getMorphClass(),
            'commentable_id'   => $this->getKey(),
            'parent_id'        => $parentId,
            'reply_to_id'      => $replyToId,
            'status'           => Config::get('comment.default_status', Config::get('comment.status.approved')),
        ]);
    }
}
