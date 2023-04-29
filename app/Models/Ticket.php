<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = ['name','issue_source_id','department','issue_category_id','comment','customer_id','ticket_status_id'];



    public function customer ()
    {
        return $this->belongsTo(related:Customer::class);
    }


    public function issueSource ()
    {
        return $this->belongsTo(related:IssueSources::class);
    }
   
    public function issueCategory ()
    {
        return $this->belongsTo(related:IssueCategory::class);
    }

    public function ticketStatus ()
    {
        return $this->belongsTo(related:TicketStatuses::class);
    }
   

}
