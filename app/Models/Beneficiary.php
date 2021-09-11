<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Beneficiary extends Model
{
    use HasFactory,SoftDeletes;

    protected $table = 'beneficiaries';

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'id_number',
        'mobile_number',
        'pin'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFullNameAttribute()
    {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }

}
