<?php

namespace App\Jobs;

use App\Models\Course;
use App\Models\WaitList;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessWaitlist implements ShouldQueue
{
    use Queueable;
    protected $studentId, $courseId;

    /**
     * Create a new job instance.
     */
    public function __construct($studentId, $courseId)
    {
        $this->studentId = $studentId;
        $this->courseId = $courseId;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $course = Course::find($this->courseId);

        if ($course->students()->count() < $course->quota) {
            $course->students()->attach($this->studentId);

            WaitList::create([
                'student_id' => $this->studentId,
                'course_id'  => $this->courseId,
                'status'     => 'accepted'
            ]);
        } else {
            WaitList::create([
                'student_id' => $this->studentId,
                'course_id'  => $this->courseId,
                'status'     => 'waiting'
            ]);
        }
    }
}
