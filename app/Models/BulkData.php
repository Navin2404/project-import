<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BulkData extends Model
{
    use HasFactory;

    protected $table = 'bulk_data'; 
    protected $fillable = ['name', 'email']; 
}