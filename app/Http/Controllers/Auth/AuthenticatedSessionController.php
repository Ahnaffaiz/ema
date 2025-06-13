<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Carbon\Carbon;
use App\Models\ExamSession;
use App\Models\ClassStudent;
use App\Models\ExamStudent;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        // Check if the logged-in user has the student role
        if (Auth::user()->hasRole('student')) {
            // Get student record
            $student = ClassStudent::where('user_id', Auth::id())->first();

            if ($student) {
                // Update session data but don't redirect to exam.take directly
                // Keep track of active exams and update their login status

                // Update login status for today's exams
                $today = Carbon::today();
                $examSessions = ExamSession::whereDate('date', $today)
                    ->where('status', 'started')  // Only consider started sessions
                    ->whereHas('examStudents', function($query) use ($student) {
                        $query->where('student_id', $student->id);
                    })
                    ->get();

                // If student has exams today, update login status
                foreach ($examSessions as $session) {
                    $examStudent = ExamStudent::where('exam_session_id', $session->id)
                        ->where('student_id', $student->id)
                        ->first();

                    if ($examStudent) {
                        // Initialize session_data if it's null
                        $sessionData = $examStudent->session_data ?? [];
                        // Make sure sessionData is an array
                        if (!is_array($sessionData)) {
                            $sessionData = [];
                        }

                        // Calculate elapsed time while logged out to pause the timer
                        if (isset($sessionData['logout_time']) && !isset($sessionData['end_exam'])) {
                            // Calculate pause duration since logout
                            $logoutTime = Carbon::parse($sessionData['logout_time']);
                            $now = Carbon::now();
                            $pauseDuration = $logoutTime->diffInSeconds($now);

                            // Add pause duration to total pause time
                            $sessionData['total_pause_time'] = ($sessionData['total_pause_time'] ?? 0) + $pauseDuration;
                        }

                        $sessionData['islogin'] = true;
                        $examStudent->session_data = $sessionData;
                        $examStudent->save();
                    }
                }
            }

            // Always redirect students to the exam login page, never directly to exam.take
            return redirect()->route('exam.login');
        }

        // Default redirect for other roles
        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
