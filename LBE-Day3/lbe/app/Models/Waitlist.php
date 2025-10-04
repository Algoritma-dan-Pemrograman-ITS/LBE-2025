<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaitList extends Model
{
    protected $table = 'waitlists';

    protected $fillable = [
        'user_id',
        'course_id',
        'status',
    ];

    // relasi many to one ke user
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // relasi many to one ke course 
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
