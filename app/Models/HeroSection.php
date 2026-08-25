<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroSection extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_name',
        'name',
        'work_details',
        'description',
        'consultancy_button_text',
        'consultancy_button_url',
        'talk_button_text',
        'talk_button_url',
        'avatar_path',
        'video_path',
    ];
}
