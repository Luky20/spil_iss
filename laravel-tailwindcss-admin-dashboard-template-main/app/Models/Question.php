<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $table = 'questions'; // Nama tabel sesuai database
    protected $primaryKey = 'idquestions'; // Primary key tabel
    public $timestamps = false; // Nonaktifkan timestamps jika tidak digunakan

    protected $fillable = ['question', 'divisions_iddivisions', 'departments_iddepartments']; // Kolom yang bisa diisi

    // Relasi ke Division
    public function division()
    {
        return $this->belongsTo(Division::class, 'divisions_iddivisions', 'iddivisions');
    }

    // Relasi ke Department
    public function department()
    {
        return $this->belongsTo(Department::class, 'departments_iddepartments', 'iddepartments');
    }
}
