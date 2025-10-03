<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $course->name }} - Course Details</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 700px; margin: 50px auto; padding: 20px; }
        .back-link { margin-bottom: 20px; }
        .back-link a { color: #007bff; text-decoration: none; }
        .back-link a:hover { text-decoration: underline; }
        .course-header { background: #f8f9fa; padding: 30px; border-radius: 8px; margin-bottom: 30px; }
        .course-title { font-size: 28px; font-weight: bold; margin-bottom: 15px; color: #333; }
        .course-description { font-size: 16px; color: #666; line-height: 1.6; margin-bottom: 20px; }
        .course-info { display: grid; grid-template-columns: 1fr 1fr; gap: 15px; }
        .info-item { background: white; padding: 15px; border-radius: 6px; border: 1px solid #e9ecef; }
        .info-label { font-weight: bold; color: #495057; margin-bottom: 5px; }
        .info-value { color: #333; }
        .enrollment-section { background: #e7f3ff; padding: 25px; border-radius: 8px; margin-top: 30px; }
        .enrollment-section h3 { margin-top: 0; color: #0066cc; }
        .btn { padding: 12px 30px; text-decoration: none; border-radius: 4px; display: inline-block; border: none; cursor: pointer; font-size: 16px; }
        .btn-primary { background: #007bff; color: white; }
        .btn-success { background: #28a745; color: white; }
        .btn:hover { opacity: 0.8; }
        .success-message { background: #d4edda; color: #155724; padding: 15px; border-radius: 4px; margin-bottom: 20px; }
        .enrollment-form { margin-top: 15px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; height: 80px; resize: vertical; }
    </style>
</head>
<body>
    <div class="back-link">
        <a href="{{ route('courses.index') }}">← Back to All Courses</a>
    </div>

    @if(session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    <div class="course-header">
        <div class="course-title">{{ $course->name }}</div>
        <div class="course-description">{{ $course->description }}</div>
        
        <div class="course-info">
            <div class="info-item">
                <div class="info-label">Instructor</div>
                <div class="info-value">{{ $course->instructor ?? 'TBA' }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Capacity</div>
                <div class="info-value">{{ $course->capacity }} students</div>
            </div>
            <div class="info-item">
                <div class="info-label">Created</div>
                <div class="info-value">{{ $course->created_at->format('M d, Y') }}</div>
            </div>
            <div class="info-item">
                <div class="info-label">Status</div>
                <div class="info-value">Open for Enrollment</div>
            </div>
        </div>
    </div>

    <div class="enrollment-section">
        <h3>🎓 Enroll in this Course</h3>
        <p>Join this course to start your learning journey. Fill out the form below to register.</p>
        
        <form method="POST" action="{{ route('courses.enroll', $course->id) }}" class="enrollment-form">
            @csrf
            
            <div class="form-group">
                <label for="motivation">Why do you want to take this course? (Optional)</label>
                <textarea id="motivation" name="motivation" 
                         placeholder="Tell us about your motivation and what you hope to learn...">{{ old('motivation') }}</textarea>
            </div>
            
            <button type="submit" class="btn btn-success">Enroll Now</button>
        </form>
    </div>

    <div style="margin-top: 30px; text-align: center;">
        <a href="{{ route('dashboard') }}" class="btn btn-primary">Back to Dashboard</a>
    </div>
</body>
</html>
