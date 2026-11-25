<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PageView extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'profile_id',
        'ip_address',
        'country_code',
        'country_name',
        'city',
        'user_agent',
        'referer',
        'device_type',
        'browser',
        'platform',
        'viewed_at',
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'viewed_at' => 'datetime',
        ];
    }

    public function profile(): BelongsTo
    {
        return $this->belongsTo(Profile::class);
    }
}
