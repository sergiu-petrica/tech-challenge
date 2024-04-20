<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Journal extends Model
{
    protected $fillable = [
        'content',
        'date',
        'client_id',
    ];

    protected $appends = [
        'url',
    ];

    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    public function getUrlAttribute(): string
    {
        return "/clients/$this->client_id/journals/$this->id";
    }
}
