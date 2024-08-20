<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class prodi extends Model
{
    use HasFactory;
    protected $table = 'prodi';
    protected $primaryKey = 'id';
    protected $fillable = [
        "nama_prd",
        "dpt_id"
    ];

    public function departement()
    {
        return $this->belongsTo(departemen::class, 'dpt_id');
    }
}
