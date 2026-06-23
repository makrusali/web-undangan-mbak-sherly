<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gift extends Model
{
    protected $fillable = [
        'bank_name',
        'account_name',
        'account_number',
        'is_active',
        'bank_image',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getFormattedAccountNumberAttribute()
    {
        return preg_replace('/(\d{4})(?=\d)/', '$1-', $this->account_number);
    }
}
