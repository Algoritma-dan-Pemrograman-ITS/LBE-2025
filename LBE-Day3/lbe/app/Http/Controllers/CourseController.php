<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{
    // Show all courses
    public function index()
    {
        $courses = Course::all();
        return view('courses.index', compact('courses'));
    }

    // Show add course form
    public function create()
    {
        return view('courses.create');
    }

    // Store new course (untuk nanti)
    public function store(Request $request)
    {
        // Logic akan ditambahkan nanti
        return redirect()->route('courses.index')->with('success', 'Course will be added');
    }

    // Show course details and enrollment form
    public function show($id)
    {
        $course = Course::findOrFail($id);
        return view('courses.show', compact('course'));
    }

    // Enroll to course (untuk nanti)
    public function enroll(Request $request, $id)
    {
        // Logic akan ditambahkan nanti
        return redirect()->route('courses.show', $id)->with('success', 'You will be enrolled');
    }
}
