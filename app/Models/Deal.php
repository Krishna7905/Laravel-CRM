<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    protected $fillable = [
        'title',
        'contact_id',
        'value',
        'stage',
        'close_date',
        'assigned_to',
        'notes'
    ];

    public function contact()
    {
        return $this->belongsTo(Contact::class);
    }

    public function employee()
    {
        return $this->belongsTo(User::class,'assigned_to');
    }
}
