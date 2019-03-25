<?php

namespace hcivelek\Categorizable\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphToMany;
use hcivelek\Categorizable\Exceptions\CategoryDoesNotExist;

trait Categorizable
{
   
  /**
   * A model may have multiple categories.
   */
    public function categories(): MorphToMany
    {
        return $this->morphToMany(
          $this->getCategoryClass(),
          'model',
          'model_has_categories',
          'model_id',
          'category_id'
      );
    }

    /**
     * Add the given (existing) category to the model.
     *
     * @param array|string|\hcivelek\Categorizable\Entitites\Category $category ...$categories
     *
     * @return $this
     */
    public function addCategory(...$categories)
    {
        if (empty($categories[0])) {
            return $this;
        }

        $categories = collect($categories)
    ->flatten()
    ->map(function ($category) {
        if (empty($category)) {
            return false;
        }

        try {
            return $this->getStoredCategory($category);
        } catch (CategoryDoesNotExist $e) {
            $categoryClass = $this->getCategoryClass();
            return $categoryClass->findOrCreate($category);
        }
    })
    ->map->id
    ->all();

        //$this->categories()->syncWithoutDetaching($categories);
        $this->categories()->sync($categories);
        $this->load('categories');
    
        return $this;
    }

    /**
     * Remove the given category from the model.
     *
     * @param string|int|\hcivelek\Categorizable\Entitites\Category $category
     */
    public function removeCategory($category)
    {
        $this->categories()->detach($this->getStoredCategory($category));

        $this->load('categories');
    }

    /* dogrudan objeyi aliyor ama olur da
    id veya name girilme ihtimaline karşı aramayı yapip obje dönebiliyor */
    protected function getStoredCategory($category)
    {
        $categoryClass = $this->getCategoryClass();
    
        if (is_numeric($category)) {
            return $categoryClass->findById($category);
        }

        if (is_string($category)) {
            return $categoryClass->findByName($category);
        }

        return $category;
    }
 

    public function getCategoryClass()
    {
        return app(\hcivelek\Categorizable\Entities\Category::class);
    }


    /**
     * Determine if the model has (one of) the given category(s).
     *
     * @param string|int|array|\Spatie\Permission\Contracts\Role|\Illuminate\Support\Collection $categories
     *
     * @return bool
     */
    public function hasCategory($categories): bool
    {
        if (is_string($categories)) {
            return $this->categories->contains('name', $categories);
        }

        if (is_int($categories)) {
            return $this->categories->contains('id', $categories);
        }

        if ($categories instanceof Category) {
            return $this->categories->contains('id', $categories->id);
        }

        if (is_array($categories)) {
            foreach ($categories as $category) {
                if ($this->hasCategory($category)) {
                    return true;
                }
            }

            return false;
        }

        return $categories->intersect($this->categories)->isNotEmpty();
    }
}
