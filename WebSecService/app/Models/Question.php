<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = ['text', 'options', 'correct_answer'];

    protected $casts = [
        'options' => 'array', // Convert JSON to array automatically
    ];
}
