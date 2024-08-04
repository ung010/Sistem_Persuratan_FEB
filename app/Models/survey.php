<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class survey extends Model
{
    use HasFactory;
    protected $table = 'survey';
    protected $primaryKey = 'id';
    protected $fillable = [
        'id',
        'nama_mhw',
        'sangat_puas',
        'puas',
        'netral',
        'kurang_puas',
        'tidak_puas',
        'feedback',
        'prd_id',
        'dpt_id',
        'jnjg_id',
        'users_id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'id',
        'nama_mhw',
        'sangat_puas',
        'puas',
        'netral',
        'kurang_puas',
        'tidak_puas',
        'feedback',
        'prd_id',
        'dpt_id',
        'jnjg_id',
        'tanggal_surat',
        'users_id',
        'remember_token',
        'create_at',
        'update_at',
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

    public function users()
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
}
