<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{   
    use HasFactory;
    
    protected $fillable = ['customer_id', 'details', 'status', 'due_date', 'files'];

    protected $casts = [
        'files' => 'array',
    ];
    

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function setDateFormat($format)
    {
        return $format;
    }

}
