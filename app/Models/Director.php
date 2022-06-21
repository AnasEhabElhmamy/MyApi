<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Director extends Model
{
    use HasFactory;

    public function Director_Emp()
    {
        # code...
        return $this->hasMany(Employee::class,'id_directors');
    }
}
