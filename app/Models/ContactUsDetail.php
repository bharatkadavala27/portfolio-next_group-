<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactUsDetail extends Model
{
    use HasFactory;

    protected $fillable = ['address', 'phone', 'email'];
}
