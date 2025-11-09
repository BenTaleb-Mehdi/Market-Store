<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    protected $fillable = [
        'key',
        'value',
        'type',
        'group',
        'label',
        'description',
    ];

    protected $casts = [
        'value' => 'string',
    ];

    // Get setting value by key
    public static function get($key, $default = null)
    {
        $setting = Cache::remember("setting_{$key}", 3600, function () use ($key) {
            return static::where('key', $key)->first();
        });

        if (!$setting) {
            return $default;
        }

        return static::castValue($setting->value, $setting->type);
    }

    // Set setting value
    public static function set($key, $value, $type = 'string', $group = 'general', $label = null, $description = null)
    {
        $setting = static::updateOrCreate(
            ['key' => $key],
            [
                'value' => $value,
                'type' => $type,
                'group' => $group,
                'label' => $label ?: $key,
                'description' => $description,
            ]
        );

        Cache::forget("setting_{$key}");
        
        return $setting;
    }

    // Cast value to appropriate type
    protected static function castValue($value, $type)
    {
        switch ($type) {
            case 'boolean':
                return filter_var($value, FILTER_VALIDATE_BOOLEAN);
            case 'integer':
                return (int) $value;
            case 'float':
                return (float) $value;
            case 'json':
                return json_decode($value, true);
            default:
                return $value;
        }
    }

    // Get settings by group
    public static function getByGroup($group)
    {
        return static::where('group', $group)->get()->mapWithKeys(function ($setting) {
            return [$setting->key => static::castValue($setting->value, $setting->type)];
        });
    }

    // Get all settings grouped
    public static function getAllGrouped()
    {
        return static::all()->groupBy('group')->map(function ($settings) {
            return $settings->mapWithKeys(function ($setting) {
                return [$setting->key => [
                    'value' => static::castValue($setting->value, $setting->type),
                    'type' => $setting->type,
                    'label' => $setting->label,
                    'description' => $setting->description,
                ]];
            });
        });
    }

    // Get currency symbol
    public static function getCurrencySymbol()
    {
        $currency = static::get('currency', 'USD');
        
        $symbols = [
            'USD' => '$',
            'EUR' => '€',
            'GBP' => '£',
            'MAD' => 'MAD ',
            'JPY' => '¥',
            'CAD' => 'C$',
            'AUD' => 'A$',
        ];
        
        return $symbols[$currency] ?? $currency . ' ';
    }

    // Format price with currency
    public static function formatPrice($amount)
    {
        $currency = static::get('currency', 'USD');
        $symbol = static::getCurrencySymbol();
        
        // For currencies that go before the amount
        if (in_array($currency, ['USD', 'EUR', 'GBP', 'JPY', 'CAD', 'AUD'])) {
            return $symbol . number_format($amount, 2);
        }
        
        // For currencies that go after the amount (like MAD)
        return number_format($amount, 2) . ' ' . $currency;
    }
}
