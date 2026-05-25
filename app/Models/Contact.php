<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Contact extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'notes',
        'assigned_to',
        'created_by'
    ];

    public function assignedUser()
    {
        return $this->belongsTo(User::class,'assigned_to');
    }

    public function creator()
    {
        return $this->belongsTo(User::class,'created_by');
    }
    public function employee()
{
    return $this->belongsTo(User::class,'assigned_to');
}
}
