<?php

//Bindings yapmayınca route model binding calismiyor..
//Auth'u yalniz yazinca da calismiyor, sürekli /home'a atiyor. web-auth beraber yazilmali..
Route::namespace('hcivelek\Categorizable\Http\Controllers')->middleware(["web","auth","bindings"])->group(function () {
    Route::resource("category",'CategoriesController')
        ->except("create","show","edit");
});