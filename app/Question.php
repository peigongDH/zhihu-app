<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    //

    protected $fillable = ['title', 'body', 'user_id'];

    public function topics()
    {
        return $this->belongsToMany(Topic::class)->withTimestamps();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function answers()
    {
        return $this->hasMany(Answer::class);
    }

    public function follows()
    {
        return $this->belongsToMany(User::class, 'user_question')->withTimestamps();
    }

    public function scopePublished($query)
    {
        return $query->where('is_hidden', 'F');
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function actions()
    {
        return $this->morphMany(Action::class, 'actionable');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'id');
    }
}
