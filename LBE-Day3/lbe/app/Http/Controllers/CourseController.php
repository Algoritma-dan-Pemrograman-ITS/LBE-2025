<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;
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
            'name' => $request->nama,
            'code' => $request->kode,
            'capacity' => $request->kuota,
            'description' => $request->deskripsi ?? ''
        ]);

        return redirect()->route('courses.index')->with('success', 'Course berhasil ditambahkan!');
    }

    // Join course directly
    public function join($id)
    {
        $course = Course::findOrFail($id);
        
        // Simple join logic - just add to relationship (implement later)
        // For now just show success message
        
        return redirect()->route('courses.index')->with('success', 'Berhasil join course: ' . $course->name);
    }
}
