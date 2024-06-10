<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigToko extends Model
{
    use HasFactory;

    protected $table = 'config_toko';

    protected $fillable = [
        'toko_id',
        'key',
        'value',
        'type',
        'description',
        'is_active',
    ];

    public static function get($key, $default = null)
    {
        $config = self::where('key', $key)->first();

        return $config ? $config->value : $default;
    }
}
