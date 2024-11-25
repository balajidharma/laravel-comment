<?php

namespace Balajidharma\LaravelComment\Models;

use Balajidharma\LaravelComment\Events\CommentCreated;
use Balajidharma\LaravelComment\Events\CommentDeleted;
use Balajidharma\LaravelComment\Events\CommentUpdated;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'commenter_type',
        'commenter_id',
        'commentable_id',
        'commentable_type',
        'content',
        'parent_id',
        'status',
        'updated_at',
        'created_at',
    ];

    /**
     * The event map for the model.
     *
     * @var array
     */
    protected $dispatchesEvents = [
        'created' => CommentCreated::class,
        'updated' => CommentUpdated::class,
        'deleted' => CommentDeleted::class,
    ];

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = [
        'commenter'
    ];

    /**
     * The user who posted the comment.
     */
    public function commenter()
    {
        return $this->morphTo();
    }

    /**
     * The model that was commented upon.
     */
    public function commentable()
    {
        return $this->morphTo();
    }

    /**
     * Get children of current comment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function children()
    {
        return $this->hasMany(config('comment.models.comment'), 'parent_id');
    }

    /**
     * Get parent of current comment.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function parent()
    {
        return $this->belongsTo(config('comment.models.comment'), 'parent_id');
    }

}
