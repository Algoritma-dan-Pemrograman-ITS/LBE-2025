# Penerapan Struktur Data dalam Website
- [Penerapan Struktur Data dalam Website](#penerapan-struktur-data-dalam-website)
  - [Queue](#queue)
    - [Waitlist Mata Kuliah](#waitlist-mata-kuliah)
  - [Hash Table/Map](#hash-tablemap)
    - [Cache dengan Hash Table](#cache-dengan-hash-table)
  - [Graf](#graf)

## Queue
Queue adalah salah satu struktur data yang paling umum digunakan dalam pengembangan web. Queue sering dipakai untuk: 
- Message Queue: mengirim pesan atau event ke sistem lain tanpa menunggu proses selesai
- Background Job: menjalankan proses berat seperti generate laporan PDF atau resize gambar tanpa mengganggu request utama pengguna. Job akan dimasukkan terlebih dahulu ke queue, response user akan dikembalikan terlebih dahulu
- Load management: membagi proses besar jadi antrian kecil agar server tidak terbebani. Pada umumnya digunakan pada sistem yang besar. Sebuah pekerjaan besar dipecah jadi beberapa batch. Batch per batch akan ditangani melalui queue
### Waitlist Mata Kuliah
Salah satu contoh penerapan queue adalah untuk sistem waitlist mata kuliah. Queue dapat digunakan untuk menampung request dari user, user tidak harus menunggu terus-menerus di website tetapi dapat meninggalkannya dan menunggu informasi/notifikasi.


Berikut langkah-langkah untuk penerapannya
1. Buat model dan migration waitlist
   ```sh
    php artisan make:model WaitList -m
   ```
   Model WaitList akan diisi seperti ini
   ```php
    <?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class WaitList extends Model
    {
        protected $fillable = [
            'user_id',
            'course_id',
            'status',
        ];

        // relasi many to one ke user
        public function user()
        {
            return $this->belongsTo(User::class);
        }

        // relasi many to one ke course 
        public function course()
        {
            return $this->belongsTo(Course::class);
        }
    }

   ```
   Migration WaitList akan diisi seperti ini
   ```php
   <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        /**
        * Run the migrations.
        */
        public function up(): void
        {
            Schema::create('waitlists', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('course_id');
                $table->string('status')->default('waiting');
                $table->timestamps();
            });
        }

        /**
        * Reverse the migrations.
        */
        public function down(): void
        {
            Schema::dropIfExists('waitlists');
        }
    };

   ```
2. Buat model dan migration course
   ```sh
   php artisan make:model Course -m
   ```
   Bagian model diisi seperti berikut
   ```php
    <?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;

    class Course extends Model
    {
        protected $fillable = [
            'kode', 
            'nama', 
            'kuota', 
        ];

        // relasi many-to-many mahasiswa dengan course
        public function user()
        {
            return $this->belongsToMany(User::class, 'course_user'); // otomatis buat tabel pivot 
        }

        // relasi one-to-many ke waitlist
        public function waitlists()
        {
            return $this->hasMany(Waitlist::class);
        }
    }
   ```
   Bagian migration diisi seperti berikut
   ```php
   <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        /**
        * Run the migrations.
        */
        public function up(): void
        {
            Schema::create('courses', function (Blueprint $table) {
                $table->id();
                $table->string('kode')->unique();
                $table->string('nama');
                $table->integer('kuota')->default(0);
                $table->timestamps();
            });
        }

        /**
        * Reverse the migrations.
        */
        public function down(): void
        {
            Schema::dropIfExists('courses');
        }
    };
   ```
3. Buat tabel pivot many-to-many antara user dengan course
   ```sh
   php artisan make:migration create_course_student_table
   ```
   Isi tabel migration sebagai berikut
   ```php
   <?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration
    {
        /**
        * Run the migrations.
        */
        public function up(): void
        {
            Schema::create('course_student', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('user_id');
                $table->unsignedBigInteger('course_id');            
                $table->timestamps();

                $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
                $table->foreign('course_id')->references('id')->on('courses')->onDelete('cascade');
            });
        }

        /**
        * Reverse the migrations.
        */
        public function down(): void
        {
            Schema::dropIfExists('course_student');
        }
    };
   ```
4. Saatnya migrate
   ```sh
   php artisan migrate
   ```
5. Buat job queue
   ```sh
   php artisan make:job ProcessWaitlist
   ```
   Di `app/jobs/ProcessWaitList` isi seperti berikut.
   ```php
   class ProcessWaitlist implements ShouldQueue
    {
        use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

        protected $studentId, $courseId;

        public function __construct($studentId, $courseId)
        {
            $this->studentId = $studentId;
            $this->courseId  = $courseId;
        }

        public function handle()
        {
            $course = Course::find($this->courseId);

            if ($course->students()->count() < $course->quota) {
                // ada slot kosong langsung masuk
                $course->students()->attach($this->studentId);

                Waitlist::create([
                    'student_id' => $this->studentId,
                    'course_id'  => $this->courseId,
                    'status'     => 'accepted'
                ]);
            } else {
                // slot penuh maka wait
                Waitlist::create([
                    'student_id' => $this->studentId,
                    'course_id'  => $this->courseId,
                    'status'     => 'waiting'
                ]);
            }
        }
    }

   ```
6. 

## Hash Table/Map
Hash Table atau Map banyak digunakan untuk pencarian data dengan kompleksitas waktu rata-rata O(1). Dalam sistem web, hash table banyak dipakai di _session management_ dan _caching_, dua hal yang krusial agar aplikasi tetap berjalan dengan aman dan cepat. Beberapa database modern (seperti Redis) menggunakan hash table di dalamnya.  
### Cache dengan Hash Table

## Graf
Graf digunakan untuk memodelkan koneksi, hubungan, atau jaringan yang kompleks. Hubungan-hubungan antar tabel dalam database sebenarnya direpresentasikan dengan graf. Bahkan saat ini, terdapat database khusus yang dibuat dalam representasi graf seperti Neo4j. Selain itu, banyak penerapan graf lainnya misalnya 
- Sistem rekomendasi berbasis Content-Based Filtering atau User-Based Filtering
  ![Recommendation System](https://blogger.googleusercontent.com/img/b/R29vZ2xl/AVvXsEgLp9pxqE0o9p7xJGl0TLTBoUpLCL1nuCwStLHtWv8gXxxeNZJhJ9hdLIsM28TEEsq8jpQBIlgrHlCe52E8my77RJtn8WGS41v00-P5rDezKEnBwobwUQ59VJzEfitaBp6fU3QxoALVALo/s1600/CF.png)
  
  
  Sistem rekomendasi sekarang marak digunakan dalam berbagai website terutama untuk menambah bumbu marketing. Beberapa aplikasi seperti Netflix, Spotify, dan E-commerce menggunakan sistem rekomendasi agar dapat menawarkan ke pengguna sesuai dengan kebutuhannya. Salah satu sistem rekomendasi paling sederhana menggunakan Content-Based Filtering dan User-Based Filtering yang meruapakan representasi dari graph.  
- Routing atau Path Finding
  
  Aplikasi-aplikasi peta seperti Google Maps, Waze, atau Grab menerapkan aplikasi Routing atau Path Finding untuk mencari rute tercepat dari A ke B.
- Knowledge Graph
  
  Knowledge Graph adalah cara menyimpan data dalam bentuk jaringan entitas dan relasi antar entitas. Jadi setiap informasi akan diketahui hubugannya. Salah satu contohnya ketika kita mencari "Albert Einstein" di mesin pencari, yang muncul bukan hanya link ke artikel tapi juga informasi tanggal lahir, penelitian, keterkaitan dengan tokoh lain. Platform seperti LinkedIn juga memakai pendekatan ini untuk memahami hubungan antar orang dan merekomendasikan koneksi baru. 
