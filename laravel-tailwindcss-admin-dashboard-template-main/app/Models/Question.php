<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $table = 'questions';

    protected $primaryKey = 'idquestions';

    protected $fillable = [
        'questions', 'idepartments_dari', 'idepartments_ke', 'jenis_survey'
    ];

    public function departmentDari()
    {
        return $this->belongsTo(Department::class, 'idepartments_dari');
    }

    public function departmentKe()
    {
        return $this->belongsTo(Department::class, 'idepartments_ke');
    }

    public function detailSurveys()
    {
        return $this->hasMany(DetailSurvey::class, 'questions_idquestions', 'idquestions');
    }
}
