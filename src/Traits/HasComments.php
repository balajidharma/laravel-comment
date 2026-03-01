<?php

namespace BalajiDharma\LaravelComment\Traits;

use Illuminate\Database\Eloquent\Model;
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

    /**
     * Add a comment as the currently authenticated user.
     *
     * @param  string   $content
     * @param  int|null $parentId
     * @return Model
     */
    public function comment(string $content, ?int $parentId = null): Model
    {
        return $this->commentAsUser(auth()->user(), $content, $parentId);
    }

    /**
     * Add a comment as a specific user.
     *
     * @param  Model    $user
     * @param  string   $content
     * @param  int|null $parentId
     * @return Model
     */
    public function commentAsUser(Model $user, string $content, ?int $parentId = null): Model
    {
        $commentClass = Config::get('comment.models.comment');

        return $commentClass::create([
            'content'          => $content,
            'commenter_type'   => $user->getMorphClass(),
            'commenter_id'     => $user->getKey(),
            'commentable_type' => $this->getMorphClass(),
            'commentable_id'   => $this->getKey(),
            'parent_id'        => $parentId,
            'status'           => Config::get('comment.default_status', 1),
        ]);
    }
}
