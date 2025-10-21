<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManagerCustomer extends Model
{
    protected $guarded = [];
    public function manager()
    {
        return $this->belongsTo(User::class, 'manager_id');
    }

    public function customer()
    {
        return $this->belongsTo(User::class, 'customer_id');
    }
}
