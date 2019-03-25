<?php

namespace hcivelek\Categorizable\Exceptions;

use InvalidArgumentException;

class CategoryDoesNotExist extends InvalidArgumentException
{
    public static function named(string $categoryName)
    {
        return new static("There is no category named `{$categoryName}`.");
    }

    public static function withId(int $categoryId)
    {
        return new static("There is no category with id `{$categoryId}`.");
    }
}
