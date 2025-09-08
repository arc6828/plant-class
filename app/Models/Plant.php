<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Plant extends Model
{
    //

    // Allow only these attributes to be mass-assigned
    protected $fillable = [
        'species_name',
        'slug',
        'common_name',
        'common_name_th',
        'genus',
        'family',
        'images',
        'num_images',
        'num_observations',
        'scientific_name',
        'description',
    ];

    // Declare the 'images' attribute as an array since it's stored as JSON in the database
    // protected $casts = [
    //     'images' => 'array',
    // ];
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'images' => 'array',
        ];
    }

    /**
     * Get the first image from the images array.
     *
     * @return string|null
     */
    public function getFirstImageAttribute()
    {
        // Check if the images array is not empty
        if (isset($this->images) && is_array($this->images) && count($this->images) > 0) {
            return $this->images[0]; // Return the first image URL
        }

        // Return null if the images array is empty or not set
        return null;
    }
}
