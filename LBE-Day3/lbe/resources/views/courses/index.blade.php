<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Courses</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; }
        .btn { padding: 10px 20px; text-decoration: none; border-radius: 4px; display: inline-block; }
        .btn-primary { background: #007bff; color: white; }
        .btn-success { background: #28a745; color: white; }
        .btn:hover { opacity: 0.8; }
        .course-card { border: 1px solid #ddd; padding: 20px; margin-bottom: 20px; border-radius: 8px; }
        .course-title { font-size: 20px; font-weight: bold; margin-bottom: 10px; }
        .course-description { color: #666; margin-bottom: 15px; }
        .course-info { font-size: 14px; color: #888; }
        .no-courses { text-align: center; color: #666; margin: 50px 0; }
    </style>
</head>
<body>
    <div class="header">
        <h1>All Courses</h1>
        <a href="{{ route('courses.create') }}" class="btn btn-success">Add New Course</a>
    </div>

    @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 20px;">
            {{ session('success') }}
        </div>
    @endif

    @if($courses->count() > 0)
        @foreach($courses as $course)
            <div class="course-card">
                <div class="course-title">{{ $course->name }}</div>
                <div class="course-description">{{ $course->description }}</div>
                <div class="course-info">
                    <strong>Capacity:</strong> {{ $course->capacity }} students | 
                    <strong>Created:</strong> {{ $course->created_at->format('M d, Y') }}
                </div>
                <div style="margin-top: 15px;">
                    <a href="{{ route('courses.show', $course->id) }}" class="btn btn-primary">View Details</a>
                </div>
            </div>
        @endforeach
    @else
        <div class="no-courses">
            <h3>No courses available yet</h3>
            <p>Be the first to add a course!</p>
        </div>
    @endif

    <div style="margin-top: 30px; text-align: center;">
        <a href="{{ route('dashboard') }}" class="btn btn-primary">Back to Dashboard</a>
    </div>
</body>
</html>
