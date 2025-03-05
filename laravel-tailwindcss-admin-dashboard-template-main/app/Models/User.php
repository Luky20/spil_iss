<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * Tabel yang digunakan oleh model ini.
     *
     * @var string
     */
    protected $table = 'users';

    /**
     * Primary Key tabel ini.
     *
     * @var string
     */
    protected $primaryKey = 'id';

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
    /**
     * Apakah timestamps aktif?
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Atribut yang dapat diisi (mass assignable).
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nik',
        'email',
        'password',
        'full_name',
        'department',
        'location',
        'division',
        'position',
        'session',
        'created_at',
        'updated_at',
        'otp_code',
        'otp_expiration',
        'last_activity',
        'session_exp',
        'departments_iddepartments',
    ];

    /**
     * Atribut yang harus disembunyikan dalam array atau JSON.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_secret',
        'two_factor_recovery_codes',
    ];

    /**
     * Atribut yang harus dikonversi secara otomatis.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'otp_expiration' => 'datetime',
        'last_activity' => 'datetime',
        'session_exp' => 'datetime',
    ];

    /**
     * Relasi ke tabel **departments**.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function department()
    {
        return $this->belongsTo(Department::class, 'departments_iddepartments', 'iddepartments');
    }
}
