<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuestionModel extends Model
{
    use HasFactory;
    protected $table = 'questions';
    protected $fillable = ['quest', 'test_id'];

    function answers() {
        return $this->hasMany(AnswerModel::class, 'question_id', 'id');
    }
}
