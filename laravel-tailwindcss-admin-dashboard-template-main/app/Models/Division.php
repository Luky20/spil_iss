<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    use HasFactory;

    protected $table = 'divisions'; // Nama tabel sesuai dengan database
    protected $primaryKey = 'iddivisions'; // Primary key dari tabel
    public $timestamps = false; // Jika tabel tidak memiliki kolom `created_at` dan `updated_at`

    protected $fillable = ['nama']; // Kolom yang bisa diisi

    // Relasi ke Department
    public function departments()
    {
        return $this->hasMany(Department::class, 'division_id', 'iddivisions');
    }

    // Relasi ke Questions
    public function questions()
    {
        return $this->hasMany(Question::class, 'divisions_iddivisions', 'iddivisions');
    }
}
