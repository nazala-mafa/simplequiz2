<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestModel extends Model
{
    use HasFactory;
    protected $table = 'tests';
    protected $fillable = ['title', 'desc', 'user_id'];
    

    function questions() {
        return $this->hasMany(QuestionModel::class, 'test_id', 'id');
    }
}
