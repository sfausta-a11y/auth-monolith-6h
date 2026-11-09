<?php

namespace App\Modules\Membership\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Member extends Model
{
    use SoftDeletes; // Implementasi Soft Deletes

    protected $fillable = ['user_id', 'member_code', 'name', 'status'];
}