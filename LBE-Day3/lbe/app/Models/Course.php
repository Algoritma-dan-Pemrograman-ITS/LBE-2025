<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'kode', 
        'nama', 
        'kuota', 
    ];

    // relasi many-to-many mahasiswa dengan course
    public function user()
    {
        return $this->belongsToMany(User::class, 'course_user'); // otomatis buat tabel pivot 
    }

    // relasi one-to-many ke waitlist
    public function waitlists()
    {
        return $this->hasMany(Waitlist::class);
    }
}
