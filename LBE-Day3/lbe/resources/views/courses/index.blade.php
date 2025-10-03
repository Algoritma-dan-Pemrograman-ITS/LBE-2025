<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Course List</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            max-width: 900px; 
            margin: 20px auto; 
            padding: 20px; 
            background: #f8f9fa;
        }
        .header { 
            display: flex; 
            justify-content: space-between; 
            align-items: center; 
            margin-bottom: 30px; 
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header h1 {
            margin: 0;
            color: #333;
        }
        .user-info {
            color: #666;
            font-size: 14px;
        }
        .btn { 
            padding: 12px 24px; 
            text-decoration: none; 
            border-radius: 6px; 
            display: inline-block; 
            font-weight: bold;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-primary { background: #007bff; color: white; }
        .btn-success { background: #28a745; color: white; }
        .btn-warning { background: #ffc107; color: #212529; }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 4px 8px rgba(0,0,0,0.2); }
        .logout-btn {
            background: #dc3545;
            color: white;
            padding: 8px 16px;
            font-size: 12px;
        }
        .course-card { 
            background: white;
            border-radius: 8px; 
            padding: 25px; 
            margin-bottom: 20px; 
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }
        .course-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        }
        .course-title { 
            font-size: 22px; 
            font-weight: bold; 
            margin-bottom: 10px; 
            color: #2c3e50;
        }
        .course-code {
            background: #e9ecef;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 12px;
            color: #495057;
            margin-left: 10px;
        }
        .course-description { 
            color: #666; 
            margin-bottom: 15px; 
            line-height: 1.5;
        }
        .course-info { 
            font-size: 14px; 
            color: #888; 
            margin-bottom: 20px;
        }
        .course-actions {
            display: flex;
            gap: 10px;
        }
        .no-courses { 
            text-align: center; 
            color: #666; 
            margin: 50px 0; 
            background: white;
            padding: 40px;
            border-radius: 8px;
        }
        .success-alert {
            background: #d4edda; 
            color: #155724; 
            padding: 15px; 
            border-radius: 6px; 
            margin-bottom: 20px;
            border-left: 4px solid #28a745;
        }
    </style>
</head>
<body>
    <div class="header">
        <div>
            <h1>🎓 Course List</h1>
            <div class="user-info">Welcome, {{ Auth::user()->name }}!</div>
        </div>
        <div style="display: flex; gap: 10px; align-items: center;">
            <a href="{{ route('courses.create') }}" class="btn btn-success">+ Add New Course</a>
            <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                @csrf
                <button type="submit" class="btn logout-btn">Logout</button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="success-alert">
            {{ session('success') }}
        </div>
    @endif

    @if($courses->count() > 0)
        @foreach($courses as $course)
            <div class="course-card">
                <div style="display: flex; align-items: center; margin-bottom: 10px;">
                    <div class="course-title">{{ $course->nama }}</div>
                    <span class="course-code">{{ $course->kode ?? 'No Code' }}</span>
                </div>                
                <div class="course-info">
                    👥 <strong>Kapasitas:</strong> {{ $course->kuota }} students
                    @if($course->created_at)
                        | 📅 <strong>Dibuat:</strong> {{ $course->created_at->format('d M Y') }}
                    @endif
                </div>
                
                <div class="course-actions">
                    <form method="POST" action="{{ route('courses.join', $course->id) }}" style="margin: 0;">
                        @csrf
                        <button type="submit" class="btn btn-primary">🚀 Join Course</button>
                    </form>
                </div>
            </div>
        @endforeach
    @else
        <div class="no-courses">
            <h3>📚 Belum ada course tersedia</h3>
            <p>Jadilah yang pertama menambahkan course!</p>
            <a href="{{ route('courses.create') }}" class="btn btn-success">+ Tambah Course Pertama</a>
        </div>
    @endif
</body>
</html>
