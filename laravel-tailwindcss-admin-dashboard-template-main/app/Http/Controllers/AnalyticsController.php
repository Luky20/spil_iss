<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AnalyticsController extends Controller
{
    public function index()
    {
        // Mapping jawaban ke skala baru (1-4 dengan Netral = 2.5)
        $answerScale = [
            1 => 1,  // Sangat Tidak Setuju
            2 => 2,  // Tidak Setuju
            3 => 2.5, // Netral
            4 => 3,  // Setuju
            5 => 4   // Sangat Setuju
        ];

        // Ambil data rata-rata berdasarkan department dan value (kategori)
        $analyticsData = DB::table('detail_surveys')
            ->join('questions', 'detail_surveys.questions_idquestions', '=', 'questions.idquestions')
            ->join('departments', 'questions.idepartments_ke', '=', 'departments.iddepartments')
            ->join('answers', 'detail_surveys.answers_idanswers', '=', 'answers.idanswers')
            ->select(
                'departments.nama as department_name',
                'questions.value as category',
                DB::raw('AVG(CASE 
                            WHEN answers.idanswers = 1 THEN 1
                            WHEN answers.idanswers = 2 THEN 2
                            WHEN answers.idanswers = 3 THEN 2.5
                            WHEN answers.idanswers = 4 THEN 3
                            WHEN answers.idanswers = 5 THEN 4
                         END) as average_score')
            )
            ->groupBy('departments.nama', 'questions.value')
            ->get();

        // Daftar kategori yang harus ada
        $categories = ['Willingness to Assist', 'Empathy', 'Caring', 'Agile', 'Reliable', 'Extra Miles'];

        // Struktur ulang data
        $formattedData = [];
        foreach ($analyticsData as $data) {
            $department = $data->department_name;
            $category = $data->category;
            $score = round($data->average_score, 2);

            if (!isset($formattedData[$department])) {
                $formattedData[$department] = [
                    'department_name' => $department,
                    'total_average' => 0,
                    'categories' => array_fill_keys($categories, '-') // Default jika kategori tidak ada
                ];
            }

            $formattedData[$department]['categories'][$category] = $score;
        }

        // Hitung rata-rata keseluruhan tiap department
        foreach ($formattedData as &$dept) {
            $validValues = array_filter($dept['categories'], fn($val) => $val !== '-');
            $dept['total_average'] = (count($validValues) > 0) ? round(array_sum($validValues) / count($validValues), 2) : '-';
        }

        return view('pages.dashboard.analytics', compact('formattedData'));
    }
}
