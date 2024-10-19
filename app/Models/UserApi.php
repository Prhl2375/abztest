<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserApi extends User
{
    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'position_id',
        'photo',
    ];
    protected $hidden = [
      'created_at',
      'updated_at',
    ];

    public function getPositionAttribute(): string|null
    {
        $position = $this->position()->first();
        if($position){
            return $position['name'];
        }
        return null;
    }

    public function getRegistrationTimestampAttribute(): int
    {
        return Carbon::parse($this->attributes['created_at'])->timestamp;
    }

    protected $appends = [
        'registration_timestamp',
        'position'
    ];
}
