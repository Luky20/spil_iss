<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataFeed;
use App\Models\User;
use App\Models\DetailSurvey;

class DashboardController extends Controller
{
    public function index()
    {
        // Daftar divisi dan jumlah total karyawan per divisi
        $divisions = [
            "BOD" => 15,
            "Commercial Division" => 140,
            "Finance & Administration Division" => 209,
            "Fleet Division" => 242,
            "Human Capital & Corporate Affairs Division" => 127,
            "Internal Audit" => 3,
            "Operation Division" => 917,
            "Strategy Development And Implementation Division" => 5,
        ];

        $surveyCompletion = [];

        foreach ($divisions as $division => $totalEmployees) {
            // Hitung jumlah user yang telah mengisi survey di setiap divisi
            $completedSurveys = User::where('division', $division)
                ->whereIn('id', DetailSurvey::pluck('users_idusers'))
                ->count();

            // Hitung persentase
            $percentage = ($totalEmployees > 0) ? ($completedSurveys / $totalEmployees) * 100 : 0;

            // Simpan dalam array
            $surveyCompletion[] = [
                'division' => $division,
                'total_employees' => $totalEmployees,
                'completed_surveys' => $completedSurveys,
                'percentage' => $percentage,
                'status' => $percentage >= 80 ? '✅' : '❌'
            ];
        }

        return view('pages.dashboard.dashboard', compact('surveyCompletion'));
    }

    /**
     * Displays the analytics screen
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function analytics()
    {
        return view('pages/dashboard/analytics');
    }

    /**
     * Displays the fintech screen
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function fintech()
    {
        return view('pages/dashboard/fintech');
    }
}
