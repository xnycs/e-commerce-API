<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterSkill extends Model
{
    use HasFactory;

    protected $table = 'register_skills';
    protected $fillable = ['register_id', 'skill_id'];

    public function register()
    {
        return $this->belongsTo(Register::class);
    }

    public function skill()
    {
        return $this->belongsTo(Skill::class);
    }
}
