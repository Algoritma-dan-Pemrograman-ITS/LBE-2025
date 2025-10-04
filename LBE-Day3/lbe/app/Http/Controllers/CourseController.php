<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\User;
use App\Models\Waitlist;
use App\Jobs\ProcessWaitlist;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    // Show all courses with join buttons
    public function index()
    {
        $courses = Course::all();
        return view('courses.index', compact('courses'));
    }

    // Show simple add course form
    public function create()
    {
        return view('courses.create');
    }

    // Store new course
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kode' => 'required|string|max:10',
            'kuota' => 'required|integer|min:1'
        ]);

        Course::create([
            'nama' => $request->nama,
            'kode' => $request->kode,
            'kuota' => $request->kuota,
            'deskripsi' => $request->deskripsi ?? ''
        ]);

        return redirect()->route('courses.index')->with('success', 'Course berhasil ditambahkan!');
    }

    // Join course directly or add to waitlist
    public function join($id)
    {
        $course = Course::findOrFail($id);
        $user = User::find(Auth::id());
        
        if($user->courses()->where('course_id', $course->id)->exists()) {
            return redirect()->route('courses.index')->with('info', 'Anda sudah bergabung di course ini.');
        }
        
        if(Waitlist::where('user_id', $user->id)->where('course_id', $course->id)->exists()) {
            return redirect()->route('courses.index')->with('info', 'Anda sudah dalam waitlist course ini.');
        }
        
        if($course->users()->count() >= $course->kuota) {
            Waitlist::create([
                'user_id' => $user->id,
                'course_id' => $course->id,
            ]);
            
            ProcessWaitlist::dispatch($course);
            
            return redirect()->route('courses.index')->with('warning', 'Course penuh! Anda ditambahkan ke waitlist: ' . $course->nama);
        }
        
        Auth::user()->courses()->attach($course->id);
        return redirect()->route('courses.index')->with('success', 'Berhasil join course: ' . $course->nama);
    }

    // Leave course and trigger waitlist processing
    public function leave($id)
    {
        $course = Course::findOrFail($id);
        $user = User::find(Auth::id());
        
        if(!$user->courses()->where('course_id', $course->id)->exists()) {
            return redirect()->route('courses.index')->with('error', 'Anda tidak terdaftar di course ini.');
        }
        
        // Remove user from course
        $user->courses()->detach($course->id);
        
        // Process waitlist to fill the empty spot
        ProcessWaitlist::dispatch($course);
        
        return redirect()->route('courses.index')->with('success', 'Berhasil keluar dari course: ' . $course->nama);
    }
}
