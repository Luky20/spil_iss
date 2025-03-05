<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    /**
     * Tabel yang digunakan oleh model ini.
     *
     * @var string
     */
    protected $table = 'surveys';

    /**
     * Primary Key tabel ini.
     *
     * @var string
     */
    protected $primaryKey = 'idsurveys';

    /**
     * Apakah primary key bertipe auto-increment?
     *
     * @var bool
     */
    public $incrementing = true;

    /**
     * Tipe data primary key.
     *
     * @var string
     */
    protected $keyType = 'bigint';

    /**
     * Apakah timestamps aktif?
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * Atribut yang dapat diisi (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'tanggal',
        'users_idusers',
    ];

    /**
     * Relasi ke tabel **users** (Setiap survey dimiliki oleh satu user).
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'users_idusers', 'id');
    }

    /**
     * Relasi ke tabel **detail_surveys** (Setiap survey memiliki banyak detail survey).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function details()
    {
        return $this->hasMany(DetailSurvey::class, 'surveys_idsurveys', 'idsurveys');
    }
}
