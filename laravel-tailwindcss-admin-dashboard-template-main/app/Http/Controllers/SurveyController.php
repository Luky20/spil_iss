<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Question;
use App\Models\Answer;
use App\Models\Survey;
use App\Models\DetailSurvey;

class SurveyController extends Controller
{
    public function selectDepartments()
    {
        $user = Auth::user();

        // Ambil semua departemen yang harus diisi oleh user
        $departments = Question::where('idepartments_dari', $user->departments_iddepartments)
            ->join('departments', 'questions.idepartments_ke', '=', 'departments.iddepartments')
            ->select('departments.iddepartments', 'departments.nama')
            ->distinct()
            ->get();

        // Jika departemen yang harus diisi <= 10, langsung gunakan semua tanpa menampilkan form pemilihan
        if ($departments->count() <= 10) {
            session(['selected_departments' => $departments->pluck('iddepartments')->toArray()]);
            return redirect()->route('survey'); // Langsung ke survei
        }

        // Jika lebih dari 10, tampilkan form pemilihan
        return view('users.select_departments', compact('departments'));
    }


    public function storeSelectedDepartments(Request $request)
    {
        $user = Auth::user();

        // Ambil semua departemen yang harus diisi oleh user
        $departments = Question::where('idepartments_dari', $user->departments_iddepartments)
            ->join('departments', 'questions.idepartments_ke', '=', 'departments.iddepartments')
            ->select('departments.iddepartments', 'departments.nama')
            ->distinct()
            ->get();

        // Jika total departemen ≤ 10, langsung atur session tanpa perlu validasi
        if ($departments->count() <= 10) {
            session(['selected_departments' => $departments->pluck('iddepartments')->toArray()]);
            return redirect()->route('survey'); 
        }

        // Validasi hanya berlaku jika user memilih secara manual
        $request->validate([
            'selected_departments' => 'required|array|min:1|max:10',
        ]);

        // Simpan departemen yang dipilih ke dalam session
        session(['selected_departments' => $request->selected_departments]);

        return redirect()->route('survey');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->withErrors(['error' => 'Silakan login terlebih dahulu.']);
        }

        
        $existingSurvey = Survey::where('users_idusers', $user->id)
            ->where('tanggal', '>=', now()->subMonths(3))
            ->exists();

        if ($existingSurvey) {
            return redirect()->route('survey.completed');
        }

        // Ambil daftar departemen yang dipilih user dari session
        $selectedDepartments = session('selected_departments', []);

        if (empty($selectedDepartments)) {
            $departments = Question::where('idepartments_dari', $user->departments_iddepartments)
                ->pluck('idepartments_ke')
                ->unique()
                ->toArray();
    
            session(['selected_departments' => $departments]);
            $selectedDepartments = $departments;
        }

        // Ambil session visited_departments
        $visitedDepartments = session('visited_departments', []);

        if (!is_array($visitedDepartments)) {
            $visitedDepartments = [];
        }

        $completedDepartments = count($visitedDepartments);
        
        $totalDepartments = count($selectedDepartments);

        // Ambil department berikutnya yang belum dijawab
        $currentDepartment = Question::where('idepartments_dari', $user->departments_iddepartments)
            ->whereIn('idepartments_ke', $selectedDepartments) // Pastikan hanya departemen yang dipilih
            ->whereNotIn('idepartments_ke', $visitedDepartments)
            ->join('departments', 'questions.idepartments_ke', '=', 'departments.iddepartments')
            ->select('questions.idepartments_ke', 'departments.nama as department_name')
            ->orderBy('questions.idepartments_ke')
            ->first();

        if (!$currentDepartment) {
            return redirect()->route('survey.completed');
        }

        $answers = Answer::all();
        $isLastPage = ($completedDepartments) >= $totalDepartments;


        $questions = Question::where('idepartments_dari', $user->departments_iddepartments)
            ->where('idepartments_ke', $currentDepartment->idepartments_ke)
            ->get();

        return view('users.index', compact(
            'currentDepartment',
            'questions',
            'totalDepartments',
            'visitedDepartments',
            'answers',
            'completedDepartments',
            'isLastPage'
        ));
    }



    /**
     * Store survey answers temporarily in `detail_survey`
     */
    public function store(Request $request)
    {
        try {
            $user = Auth::user();
            if (!$user) {
                return response()->json(['error' => 'User tidak ditemukan.'], 401);
            }

            // **Pastikan ada jawaban yang dikirim**
            if (!$request->has('answers') || empty($request->answers)) {
                return response()->json(['error' => 'Harap isi semua pertanyaan sebelum lanjut.'], 422);
            }

            // **Simpan jawaban di `detail_survey` tanpa mengisi `surveys_idsurveys` dulu**
            foreach ($request->answers as $question_id => $answer_id) {
                DetailSurvey::updateOrCreate(
                    [
                        'questions_idquestions' => $question_id,
                        'users_idusers' => $user->id, // Hubungkan ke user
                    ],
                    [
                        'answers_idanswers' => $answer_id
                    ]
                );
            }

            // **Ambil total department dari database jika session kosong**
            if (!session()->has('total_departments')) {
                $totalDepartments = Question::where('idepartments_dari', $user->departments_iddepartments)
                    ->distinct('idepartments_ke')
                    ->count();

                session(['total_departments' => $totalDepartments]);
            }

            // **Masukkan department_id ke visited_departments hanya setelah jawaban disimpan**
            $visitedDepartments = session('visited_departments', []);
            if (!in_array($request->department_id, $visitedDepartments)) {
                $visitedDepartments[] = $request->department_id;
            }
            session(['visited_departments' => $visitedDepartments]);

            // **Hitung progress dengan memastikan `total_departments` benar**
            $completedDepartments = count($visitedDepartments);
            $totalDepartments = session('total_departments', 1);
            $progressPercentage = ($completedDepartments / max(1, $totalDepartments)) * 100;

            return response()->json([
                'message' => 'Survey berhasil disimpan.',
                'completedDepartments' => $completedDepartments,
                'progressPercentage' => $progressPercentage,
                'isLastPage' => ($completedDepartments >= $totalDepartments) // Perbaikan di sini
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan saat menyimpan data.',
                'message' => $e->getMessage()
            ], 500);
        }
    }



    /**
     * Submit final survey and update `detail_survey` with `surveys_idsurveys`
     */
    public function submit(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user) {
                return response()->json(['error' => 'User tidak ditemukan.'], 401);
            }

            // Simpan entri di tabel `surveys`
            $survey = Survey::create([
                'users_idusers' => $user->id,
                'tanggal' => now()
            ]);

            // Update `detail_survey` dengan `surveys_idsurveys`
            DetailSurvey::where('users_idusers', $user->id)
                ->whereNull('surveys_idsurveys')
                ->update(['surveys_idsurveys' => $survey->idsurveys]);

            // Reset session progress
            session()->forget(['completed_departments', 'visited_departments']);

            return response()->json([
                'message' => 'Survey berhasil disubmit!',
                'redirect' => route('survey.completed')
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Terjadi kesalahan saat menyimpan survey.',
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
