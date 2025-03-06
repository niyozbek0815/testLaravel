<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Regions extends Model
{
    protected $fillable = [
        'name',
    ];
    public function getNameAttribute($value)
    {
        return $this->shortenName($value);
    }

    /**
     * Set the name with automatic abbreviation.
     */
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $this->shortenName($value);
    }

    /**
     */
    private function shortenName($value)
    {
        if (str_ends_with($value, 'Respublikasi')) {
            return str_replace('Respublikasi', 'Res', $value);
        }

        if (str_ends_with($value, 'viloyati')) {
            return str_replace('viloyati', 'Vil', $value);
        }

        if (str_ends_with($value, 'shahri')) {
            return str_replace('shahri', 'Shah', $value);
        }

        return $value;
    }
}