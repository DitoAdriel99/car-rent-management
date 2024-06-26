<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'brand', 'model', 'license_plate', 'image',
    ];

     /**
     * Store the car image.
     *
     * @param  \Illuminate\Http\UploadedFile  $image
     * @return string|null
     */
    public function storeImage($image)
    {
        if ($image) {
            $imagePath = $image->store('car_images', 'public');
            return $imagePath;
        }

        return null;
    }


}
