<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Question;
use App\Models\Answer;

class SurveyController extends Controller
{
    /**
     * Display the survey form.
     */
    public function index()
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login')->withErrors(['error' => 'Silakan login terlebih dahulu.']);
        }

        // Ambil department berdasarkan nama yang sama dengan user
        $department = Department::where('nama', $user->department)->first();

        if (!$department) {
            return redirect()->route('dashboard')->withErrors(['error' => 'Departemen tidak ditemukan.']);
        }

        // Ambil pertanyaan yang sesuai dengan department
        $questions = Question::where('idepartments_ke', $department->iddepartments)->get();

        // Ambil pilihan jawaban untuk skala likert
        $answers = Answer::all();

        // Hitung progress survey berdasarkan department yang sudah diisi
        $totalDepartments = Department::count();
        $completedDepartments = $this->getCompletedDepartments($user->id); 
        $progressPercentage = ($totalDepartments > 0) ? ($completedDepartments / $totalDepartments) * 100 : 0;

        return view('users.index', compact('department', 'questions', 'answers', 'progressPercentage', 'totalDepartments', 'completedDepartments'));
    }

    /**
     * Get the count of completed departments for the user.
     */
    private function getCompletedDepartments($userId)
    {
        return \DB::table('detail_surveys')
            ->join('questions', 'detail_surveys.questions_idquestions', '=', 'questions.idquestions')
            ->join('surveys', 'detail_surveys.surveys_idsurveys', '=', 'surveys.idsurveys')
            ->where('surveys.users_idusers', $userId)
            ->select('questions.idepartments_ke')
            ->distinct()
            ->count();
    }
}
