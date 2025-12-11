<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Priority.
 *
 * @property int $id
 * @property string $name
 * @property Collection|Ticket[] $tickets
 */
class Priority extends Model
{
    public const CRITICAL = 1;
    public const HIGH = 2;
    public const MEDIUM = 3;
    public const LOW = 4;
    public const ENHANCEMENT = 5;

    public $timestamps = false;
    protected $table = 'priorities';

    protected $fillable = [
        'name',
        'sla_hours',
        'bonus_cap',
        'early_cap',
        'is_time_sensitive',
    ];

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
