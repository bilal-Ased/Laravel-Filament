<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['name','issue_source','department','issue_category','comment','customer_id','ticket_status'];



    public function Customer ()
    {
        return $this->belongsTo(related:Customer::class);
    }


    public function IssueSources ()
    {
        return $this->belongsTo(related:IssueSources::class);
    }
   

}
