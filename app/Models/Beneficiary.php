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


    public function getFullNameAttribute()
    {
        return ucfirst($this->first_name) . ' ' . ucfirst($this->last_name);
    }

    public function users()
    {
        return $this->belongsToMany(User::class,'beneficiary_user','beneficiary_id','user_id');
    }

}
