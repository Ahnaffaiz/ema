<?php

namespace App\Livewire;

use App\Models\ClassStudent;
use App\Models\Exam;
use App\Models\ExamSession;
use App\Models\Question;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Title;
use Livewire\Component;

class Dashboard extends Component
{
    #[Title('Dashboard')]
    public function render()
    {
        // Get logged in user
        $user = Auth::user();

        return view('livewire.dashboard');
    }
}
