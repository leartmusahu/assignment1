<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'instructor_id']; 

    public function instructor()
    {
        return $this->belongsTo(Instructor::class);
    }

    public function students()
{
    return $this->belongsToMany(User::class, 'course_user', 'course_id', 'user_id');
}


    public function threads()
    {
        return $this->hasMany(Thread::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'enrollments');
    }
    

}
