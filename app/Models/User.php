<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $primaryKey = 'id';
    protected $fillable = [
        'nama',
        'id',
        'nmr_unik',
        'kota',
        'tanggal_lahir',
        'nowa',
        'almt_asl',
        'nama_ibu',
        'role',
        'prd_id',
        'dpt_id',
        'jnjg_id',
        'foto',
        'email',
        'akses',
        'password',
        'catatan_user',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'nmr_unik',
        'kota',
        'tanggal_lahir',
        'nowa',
        'almt_asl',
        'nama_ibu',
        'role',
        'prd_id',
        'dpt_id',
        'jnjg_id',
        'foto',
        'email',
        'akses',
        'password',
        'catatan_user',
        'remember_token',
        'create_at',
        'update_at',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function getTempatTanggalLahirAttribute()
    {
        return $this->kota . ', ' . $this->tanggal_lahir;
    }

    public function departemen()
    {
        return $this->belongsTo(departemen::class, 'dpt_id', 'id');
    }

    public function prodi()
    {
        return $this->belongsTo(prodi::class, 'prd_id', 'id');
    }

    public function jenjang()
    {
        return $this->belongsTo(jenjang_pendidikan::class, 'jnjg_id', 'id');
    }
}
