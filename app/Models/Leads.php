<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class leads extends Model
{
    use HasFactory;
    protected $fillable = ['lead_source_id','customer_id','lead_stage_id','product_id'];


    public function customer()
    {
        return $this->belongsTo(related:Customer::class);
    }

    public function leadSource()
    {
        return $this->belongsTo(related:leadSource::class);
    }

    public function leadStage()
    {
        return $this->belongsTo(related:leadStage::class);
    }

    public function product()
    {
        return $this->belongsTo(related:Products::class);
    }
}
