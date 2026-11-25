<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LinkClick extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'bio_link_id',
        'ip_address',
        'country_code',
        'country_name',
        'city',
        'user_agent',
        'referer',
        'device_type',
        'clicked_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'clicked_at' => 'datetime',
        ];
    }

    public function bioLink(): BelongsTo
    {
        return $this->belongsTo(BioLink::class);
    }
}
