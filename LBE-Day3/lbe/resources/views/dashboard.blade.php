<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 50px auto; padding: 20px; }
        .welcome { background: #f8f9fa; padding: 30px; border-radius: 8px; margin-bottom: 30px; text-align: center; }
        .welcome h1 { margin: 0 0 10px 0; color: #333; }
        .welcome p { margin: 0; color: #666; }
        .menu-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px; }
        .menu-card { background: white; border: 2px solid #e9ecef; padding: 25px; border-radius: 8px; text-align: center; transition: all 0.3s; }
        .menu-card:hover { border-color: #007bff; transform: translateY(-2px); box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .menu-card h3 { margin: 0 0 15px 0; color: #333; }
        .menu-card p { color: #666; margin-bottom: 20px; }
        .btn { padding: 12px 24px; text-decoration: none; border-radius: 4px; display: inline-block; font-weight: bold; }
        .btn-primary { background: #007bff; color: white; }
        .btn-success { background: #28a745; color: white; }
        .btn:hover { opacity: 0.8; }
        .icon { font-size: 48px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <div class="welcome">
        <h1>Welcome, {{ Auth::user()->name }}!</h1>
        <p>What would you like to do today?</p>
    </div>

    <div class="menu-grid">
        <div class="menu-card">
            <div class="icon">📚</div>
            <h3>Browse Courses</h3>
            <p>View all available courses and find something interesting to learn</p>
            <a href="{{ route('courses.index') }}" class="btn btn-primary">View All Courses</a>
        </div>

        <div class="menu-card">
            <div class="icon">➕</div>
            <h3>Add New Course</h3>
            <p>Create a new course and share your knowledge with others</p>
            <a href="{{ route('courses.create') }}" class="btn btn-success">Create Course</a>
        </div>

        <div class="menu-card">
            <div class="icon">👤</div>
            <h3>My Profile</h3>
            <p>View and manage your profile information</p>
            <a href="#" class="btn btn-primary">View Profile</a>
        </div>

        <div class="menu-card">
            <div class="icon">📝</div>
            <h3>My Enrollments</h3>
            <p>See all courses you're enrolled in and track your progress</p>
            <a href="#" class="btn btn-primary">My Courses</a>
        </div>
    </div>
</body>
</html>
