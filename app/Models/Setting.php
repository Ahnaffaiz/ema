<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = [
        'school_name',
        'address',
        'phone',
        'email',
        'logo',
        'chairman',
        'nip',
    ];

    /**
     * Get settings as a key-value pair
     *
     * @return array
     */
    public static function getSettings()
    {
        $settings = self::first();
        if (!$settings) {
            return [
                'school_name' => '',
                'address' => '',
                'phone' => '',
                'email' => '',
                'logo' => '',
                'chairman' => '',
                'nip' => '',
            ];
        }

        return $settings->toArray();
    }
}
