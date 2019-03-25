<?php

namespace hcivelek\Categorizable\Entities;

use Illuminate\Database\Eloquent\Model;
use hcivelek\Categorizable\Exceptions\CategoryDoesNotExist;

class Category extends Model
{
    public $guarded = ['id'];

    public static function findByName(string $name)
    {
        $category = static::where('name', $name)->first();

        if (! $category) {
            throw CategoryDoesNotExist::named($name);
        }

        return $category;
    }

    public static function findById(int $id)
    {
        $category = static::where('id', $id)->first();

        if (! $category) {
            throw CategoryDoesNotExist::withId($id);
        }

        return $category;
    }
    
    /**
     * Find or create category by its name.
     *
     * @param string $name
     *
     * @return \hcivelek\Categorizable\Entities\Category
     */
    public static function findOrCreate(string $name)
    {
        $category = static::where('name', $name)->first();

        if (! $category) {
            return static::query()->create(['name' => $name]);
        }

        return $category;
    }

    public function scopeFilter($query)
    {
        return $query;
    }
}
