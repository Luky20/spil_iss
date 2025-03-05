<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailSurvey extends Model
{
    use HasFactory;

    protected $table = 'detail_surveys';

    protected $primaryKey = 'id';

    protected $fillable = [
        'surveys_idsurveys', 'questions_idquestions', 'answers_idanswers'
    ];

    public function survey()
    {
        return $this->belongsTo(Survey::class, 'surveys_idsurveys');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'questions_idquestions');
    }

    public function answer()
    {
        return $this->belongsTo(Answer::class, 'answers_idanswers');
    }
}
