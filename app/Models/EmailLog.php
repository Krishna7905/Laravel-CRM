<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailLog extends Model
{
    protected $fillable = [
        'lead_id',
        'subject',
        'body'
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }
    public function user()
{
    return $this->belongsTo(User::class);
}
}