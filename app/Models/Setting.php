<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'group',
        'key',
        'value',
        'type',
        'label',
        'description',
        'is_locked',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'is_locked' => 'boolean',
    ];

    /**
     * Get the value formatted based on the type.
     */
    public function getFormattedValueAttribute()
    {
        $value = $this->value;

        if (is_null($value)) {
            return null;
        }

        switch ($this->type) {
            case 'boolean':
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
            case 'integer':
                return intval($value);
            case 'json':
            case 'array':
                return json_decode($value, true) ?? [];
            default:
                return $value;
        }
    }
}
