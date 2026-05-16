<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactUs extends Model
{
    use HasFactory;

    // Define the table name if it's different from the default (pluralized table name)
    protected $table = 'contactus_form_submission';

    // Specify which fields are mass assignable (for security reasons)
    protected $fillable = [
        'name',
        'email',
        'phone',
        'message'
    ];
}
