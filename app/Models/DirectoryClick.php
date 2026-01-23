<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DirectoryClick extends Model
{
    use HasFactory;

    protected $fillable = [
        'directory_item_id',
        'user_id',
        'ip_address',
        'user_agent',
        'clicked_at',
    ];

    public $timestamps = false;

    protected $casts = [
        'clicked_at' => 'datetime',
    ];

    public function directoryItem()
    {
        return $this->belongsTo(DirectoryItem::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
