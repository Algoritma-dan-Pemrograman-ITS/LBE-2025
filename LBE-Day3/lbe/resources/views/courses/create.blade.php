<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Course</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            max-width: 600px; 
            margin: 20px auto; 
            padding: 20px; 
            background: #f8f9fa;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .form-group { margin-bottom: 20px; }
        label { 
            display: block; 
            margin-bottom: 8px; 
            font-weight: bold; 
            color: #333;
        }
        input, textarea { 
            width: 100%; 
            padding: 12px; 
            border: 2px solid #e9ecef; 
            border-radius: 6px; 
            font-size: 16px; 
            transition: border-color 0.3s;
            box-sizing: border-box;
        }
        input:focus, textarea:focus {
            outline: none;
            border-color: #007bff;
        }
        textarea { 
            height: 100px; 
            resize: vertical; 
            font-family: inherit;
        }
        .btn { 
            padding: 12px 30px; 
            border: none; 
            border-radius: 6px; 
            cursor: pointer; 
            font-size: 16px; 
            font-weight: bold;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s;
        }
        .btn-success { 
            background: #28a745; 
            color: white; 
        }
        .btn-success:hover { 
            background: #1e7e34;
            transform: translateY(-2px);
        }
        .btn-secondary {
            background: #6c757d;
            color: white;
            margin-right: 10px;
        }
        .btn-secondary:hover {
            background: #545b62;
            transform: translateY(-2px);
        }
        .error { 
            color: #dc3545; 
            font-size: 14px; 
            margin-top: 5px; 
        }
        .back-link { 
            margin-bottom: 30px; 
        }
        .back-link a { 
            color: #007bff; 
            text-decoration: none; 
            font-weight: bold;
        }
        .back-link a:hover { 
            text-decoration: underline; 
        }
        h1 {
            color: #2c3e50;
            margin-bottom: 30px;
            text-align: center;
        }
        .form-actions {
            margin-top: 30px;
            text-align: center;
        }
        .required {
            color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="back-link">
            <a href="{{ route('courses.index') }}">← Kembali ke Course List</a>
        </div>

        <h1>➕ Tambah Course Baru</h1>

        <form method="POST" action="{{ route('courses.store') }}">
            @csrf
            
            <div class="form-group">
                <label for="nama">Nama Course <span class="required">*</span></label>
                <input type="text" id="nama" name="nama" value="{{ old('nama') }}" required 
                       placeholder="Contoh: Introduction to Programming">
                @error('nama')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="kode">Kode Course <span class="required">*</span></label>
                <input type="text" id="kode" name="kode" value="{{ old('kode') }}" required 
                       placeholder="Contoh: EF231010">
                @error('kode')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="kuota">Kuota Maksimal <span class="required">*</span></label>
                <input type="number" id="kuota" name="kuota" value="{{ old('kuota') }}" 
                       min="1" max="1000" required placeholder="Contoh: 30">
                @error('kuota')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="deskripsi">Deskripsi Course (opsional)</label>
                <textarea id="deskripsi" name="deskripsi" 
                          placeholder="Jelaskan singkat tentang course ini...">{{ old('deskripsi') }}</textarea>
                @error('deskripsi')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('courses.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-success">✅ Simpan Course</button>
            </div>
        </form>
    </div>
</body>
</html>
            @error('kuota')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit">Create Course</button>
    </form>
</body>
</html>
