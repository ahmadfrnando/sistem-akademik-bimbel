<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefMapel extends Model
{
    use HasFactory;

    protected $table = 'ref_mapel';
    
    protected $guarded = ['id'];

}
