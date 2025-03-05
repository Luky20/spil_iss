<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    use HasFactory;

    protected $table = 'answer'; // Nama tabel di database

    protected $primaryKey = 'idanswer'; // Primary key tabel

    public $timestamps = false; // Menonaktifkan timestamps (created_at & updated_at)

    protected $fillable = [
        'nama',
    ];
}
