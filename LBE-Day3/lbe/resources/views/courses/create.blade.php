<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Course</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 600px; margin: 50px auto; padding: 20px; }
        .form-group { margin-bottom: 20px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, textarea { width: 100%; padding: 10px; border: 1px solid #ddd; border-radius: 4px; font-size: 16px; }
        textarea { height: 100px; resize: vertical; }
        button { background: #28a745; color: white; padding: 12px 30px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; }
        button:hover { background: #1e7e34; }
        .error { color: red; font-size: 14px; margin-top: 5px; }
        .back-link { margin-bottom: 20px; }
        .back-link a { color: #007bff; text-decoration: none; }
        .back-link a:hover { text-decoration: underline; }
    </style>
</head>
<body>
    <div class="back-link">
        <a href="{{ route('courses.index') }}">← Back to All Courses</a>
    </div>

    <h1>Add New Course</h1>

    <form method="POST" action="{{ route('courses.store') }}">
        @csrf
        
        <div class="form-group">
            <label for="name">Course Name:</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}" required 
                   placeholder="e.g., Introduction to Programming">
            @error('name')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="description">Description:</label>
            <textarea id="description" name="description" required 
                      placeholder="Describe what this course is about...">{{ old('description') }}</textarea>
            @error('description')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="capacity">Capacity (Max Students):</label>
            <input type="number" id="capacity" name="capacity" value="{{ old('capacity') }}" 
                   min="1" max="1000" required placeholder="e.g., 30">
            @error('capacity')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        
        <div class="form-group">
            <label for="instructor">Instructor Name:</label>
            <input type="text" id="instructor" name="instructor" value="{{ old('instructor') }}" 
                   required placeholder="e.g., Dr. John Doe">
            @error('instructor')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        
        <button type="submit">Create Course</button>
    </form>
</body>
</html>
