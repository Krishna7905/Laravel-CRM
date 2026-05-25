<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    protected $fillable = [
        'title',
        'description',
        'due_date',
        'status',
        'contact_id',
        'assigned_to'
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function employee()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
}
