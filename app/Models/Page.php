<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $guarded = [];

    public function parent()
    {
        return $this->belongsTo(Page::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(Page::class, 'parent_id')->with('children'); // Recursive loading
    }

    public static function findPageBySlug($slugs)
    {
        $parent = null;

        foreach ($slugs as $index => $slug) {
            if ($index === 0) {
                // Get the root page
                $parent = Page::where('slug', $slug)->whereNull('parent_id')->first();
            } else {
                if (!$parent) return null; 
                $parent = $parent->children()->where('slug', $slug)->first();
            }

            if (!$parent) return null; 
        }

        return $parent ?: null; 
    }
    
    public function scopeFindByPath($query, array $slugs)
    {
        $parent = null;

        foreach ($slugs as $index => $slug) {
            if ($index === 0) {
                // Get the root page
                $parent = Page::where('slug', $slug)->whereNull('parent_id')->first();
            } else {
                if (!$parent) return null; 
                $parent = $parent->children()->where('slug', $slug)->first();
            }

            if (!$parent) return null; 
        }

        return $parent ?: null;
    }




    public static function getNestedPages($parentId = null)
    {
        return self::where('parent_id', $parentId)
            ->with('children')
            ->get();
    }
}
