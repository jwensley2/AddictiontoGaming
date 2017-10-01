<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Donor extends Model
{
    protected $guarded = [];

    public static $rules = [];

    /**
     * Return the date fields to be mutated
     * http://laravel.com/docs/eloquent#date-mutators
     *
     * @return array
     */
    public function getDates()
    {
        return ['created_at', 'updated_at', 'expires_at'];
    }

    /**
     * Get the donations relationship
     *
     * @return object
     */
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    /**
     * Get the donors full name
     *
     * @return string
     */
    public function getNameAttribute()
    {
        $this->attributes['name'] = '';

        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Calculate the total amount a donor has donated
     *
     * @return int
     */
    public function getTotalDonatedAttribute()
    {
        $this->attributes['total_donated'] = '';

        $total = $this->donations()
            ->where('status', 'completed')
            ->sum('gross');

        return number_format($total, 2);
    }
}