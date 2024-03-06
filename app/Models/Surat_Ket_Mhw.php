<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Surat_Ket_Mhw extends Model
{
    protected $table = "srt_ket_mhs";
    protected $primaryKey = 'id';
    protected $fillable = ['no_surat', 'alamat', 'tjn_srt', 'thn_awl', 
    'thn_akh', 'semester', 'role', 'users_id'];
    // public $timestamps = false;
}
