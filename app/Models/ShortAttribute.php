<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortAttribute extends Model
{
    use HasFactory;

    protected $fillable = ['attribute_id', 'key', 'value'];

    /**
     * Get the value attribute.
     *
     * @param  string  $value
     * @return array
     */
    public function getValueAttribute($value)
    {
        return array_filter(explode(',', $value));
    }

    /**
     * Set the value attribute.
     *
     * @param  array|string  $value
     * @return void
     */
    public function setValueAttribute($value)
    {
        $this->attributes['value'] = is_array($value) ? implode(',', array_filter($value)) : $value;
    }

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
