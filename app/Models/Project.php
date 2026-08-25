<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'sub_title',
        'category_tags',
        'cover_image',
        'detail_images',
        'description',
        'live_website_url',
        'live_mobile_app_url',
        'sort_order',
        'is_featured',
    ];

    protected $casts = [
        'detail_images' => 'array',
        'is_featured' => 'boolean',
    ];
}
