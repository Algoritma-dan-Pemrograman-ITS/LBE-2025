<?php

namespace App\Jobs;

use App\Models\Course;
use App\Models\Waitlist;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class ProcessWaitlist implements ShouldQueue
{
    use Queueable;
    protected $course;

    /**
     * Create a new job instance.
     */
    public function __construct(Course $course)
    {
        $this->course = $course;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $course = $this->course;
        
        // Check if there are available spots
        $currentEnrollment = $course->users()->count();
        $availableSpots = $course->kuota - $currentEnrollment;
        
        if ($availableSpots > 0) {
            // Get waitlisted users for this course
            $waitlistUsers = Waitlist::where('course_id', $course->id)
                ->orderBy('created_at', 'asc')
                ->limit($availableSpots)
                ->get();
            
            foreach ($waitlistUsers as $waitlistEntry) {
                // Add user to course
                $course->users()->attach($waitlistEntry->user_id);
                
                // Remove from waitlist
                $waitlistEntry->delete();
            }
        }
    }
}
