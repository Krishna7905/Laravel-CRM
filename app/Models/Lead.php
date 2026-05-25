<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class Lead extends Model
{

    protected $fillable = [
        'name',
        'email',
        'phone',
        'company',
        'status',
        'assigned_to',
        'notes',
        'created_by'
    ];

    public function assignedUser()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function employee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
    public function emailLogs()
{
    return $this->hasMany(EmailLog::class);
}
    use SoftDeletes;

}

