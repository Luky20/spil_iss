<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $table = 'departments'; // Nama tabel sesuai database
    protected $primaryKey = 'iddepartments'; // Primary key tabel
    public $timestamps = false; // Nonaktifkan timestamps jika tidak digunakan

    protected $fillable = ['nama']; // Kolom yang bisa diisi

    // Relasi ke Division
    public function division()
    {
        return $this->belongsTo(Division::class, 'division_id', 'iddivisions');
    }

    // Relasi ke Questions
    public function questions()
    {
        return $this->hasMany(Question::class, 'departments_iddepartments', 'iddepartments');
    }
}
