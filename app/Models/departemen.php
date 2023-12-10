<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class departemen extends Model
{
    use HasFactory;

    protected $table = 'departement';
    protected $primaryKey = 'id';
    protected $fillable = [
        "nama_dpt"
    ];

    // public function Dosens(){
    //     return $this->hasMany(User::class, 'dosen_id', 'id');
    // }
}
