<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PertanyaanKeamanan extends Model
{
    protected $table = 'pertanyaan_keamanans';
    
    protected $fillable = [
        'pertanyaan',
    ];

    public function ortu()
    {
        return $this->hasMany(User::class, 'id_pertanyaan');
    }
}
