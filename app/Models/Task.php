<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'description', 'employee_id', 'deadline', 'status', 'time_spent', 'feedback','priority'];

    public function employee()
{
    return $this->belongsTo(User::class, 'employee_id');
}

}
