<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'kode', 
        'nama', 
        'kuota',
        'deskripsi',
    ];

    // relasi many-to-many mahasiswa dengan course
    public function users()
    {
        return $this->belongsToMany(\App\Models\User::class, 'course_student', 'course_id', 'user_id'); // otomatis buat tabel pivot 
    }

    // relasi one-to-many ke waitlist
    public function waitlists()
    {
        return $this->hasMany(\App\Models\Waitlist::class);
    }
}
