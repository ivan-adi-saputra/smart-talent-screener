<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Chat extends Model
{
    protected $fillable = [
        'candidate_id',
        'parent_id',
        'message',
        'response',
    ];

    public function candidate()
    {
        return $this->belongsTo(Candidate::class);
    }

    public function parent()
    {
        return $this->belongsTo(Chat::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Chat::class, 'parent_id');
    }
}
