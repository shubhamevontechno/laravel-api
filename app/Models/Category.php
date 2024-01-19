<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = ['name', 'parent_id'];

    // Relationship: Each category belongs to a parent category
    public function parentCategory()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Relationship: Each category has many subcategories
    public function subcategories()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

}
