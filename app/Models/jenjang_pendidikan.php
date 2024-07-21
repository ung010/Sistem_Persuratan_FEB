<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class jenjang_pendidikan extends Model
{
    use HasFactory;
    protected $table = 'jenjang_pendidikan';
    protected $primaryKey = 'id';
    protected $fillable = [
        "nama_jnjg"
    ];
}
