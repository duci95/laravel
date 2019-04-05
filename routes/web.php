<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::pattern('id','[0-9]+');
Route::pattern('cat','[\w]+');
Route::pattern('char','[\w]+');

Route::get('/prijava',"FrontendController@login")->name("renderLogin");
Route::get('/registracija',"FrontendController@register")->name("renderRegistration");

Route::get("/logout", "LogRegController@logout")->name("logout");

Route::post('/login','LogRegController@login');
Route::post('/register','LogRegController@register');

Route::get('/activation/{param}','LogRegController@activation')->name('activation');

Route::get ("/kontakt","FrontendController@kontakt")->name("kontakt");
Route::get ("/autor","FrontendController@autor")->name("autor");

Route::post("/feedback","UserFeedbackController@feedback");
Route::get ("/","SeriesController@newest")->name("pocetna");
Route::get ("/serija/{id}","SeriesController@show");
Route::get("/{cat}","CategoriesController@show")->name('category');
Route::get("/pretraga/{char}","SeriesController@search");

Route::get("/komentari/{idseries}","CommentsController@showSeriesComments");


Route::group(['middleware' => 'session'] , function() {
    Route::post('/komentari', 'CommentsController@store');

    Route::post("/seriesDislike", "SeriesController@dislike");
    Route::post("/seriesLike", "SeriesController@like");

    Route::post('/commentsLike', "CommentsController@like");
    Route::post('/commentsDislike', "CommentsController@dislike");
    Route::delete('/commentsDelete', 'CommentsController@delete');

});

Route::group(['middleware' => 'admin'] , function(){

    Route::get("/admin/sponzori/spisak","Admin\SponsorController@index")->name("sponsor-show");
    Route::get("/admin/sponzori/forma","Admin\SponsorController@create")->name("sponsor-form");
    Route::get("/admin/sponzori/forma-izmena/{id}","Admin\SponsorController@edit")->name("sponsor-one-render");
    Route::post("/admin/sponzori/unos","Admin\SponsorController@store")->name("sponsor-insert");
    Route::delete("/admin/sponzori/brisanje/{id}","Admin\SponsorController@destroy");
    Route::put("/admin/sponzori/izmena/link/{id}","Admin\SponsorController@updateLink")->name("sponsor-update-link");
    Route::put("/admin/sponzori/izmena/slika/{id}","Admin\SponsorController@updatePicture")->name("sponsor-update-picture");

    Route::get("/admin/korisnici/spisak","Admin\UserController@index")->name("user-show");
    Route::get("/admin/korisnici/forma","Admin\UserController@create")->name("user-form");
    Route::post("/admin/korisnici/unos","Admin\UserController@store");
    Route::get("/admin/korisnici/forma-izmena/{id}","Admin\UserController@edit")->name("user-one-render");
    Route::post("/admin/korisnici/izmena/{id}","Admin\UserController@update");
    Route::delete("/admin/korisnici/brisanje/{id}","Admin\UserController@destroy");

    Route::get("/admin/zanrovi/spisak","Admin\GenreController@index")->name("genre-show");
    Route::get("/admin/zanrovi/forma","Admin\GenreController@create")->name("genre-form");
    Route::get("/admin/zanrovi/forma/{id}","Admin\GenreController@edit")->name("genre-one-render");
    Route::post("/admin/zanrovi/izmena/{id}","Admin\GenreController@update");
    Route::delete("/admin/zanrovi/brisanje/{id}","Admin\GenreController@destroy");
    Route::post("/admin/zanrovi/unos","Admin\GenreController@store");

    Route::get("/admin/uloge/spisak","Admin\RoleController@index")->name('role-show');
    Route::delete("/admin/uloge/brisanje/{id}","Admin\RoleController@destroy");
    Route::get("/admin/uloge/forma","Admin\RoleController@create")->name("role-form");
    Route::post("/admin/uloge/unos","Admin\RoleController@store")->name("role-insert");
    Route::get("/admin/uloge/forma-izmena/{id}","Admin\RoleController@edit")->name("role-one-render");
    Route::put("/admin/uloge/izmena/{id}","Admin\RoleController@update");

    Route::get("/admin/serije/spisak",'Admin\SeriesController@index')->name("series-show");
    Route::get("/admin/serije/forma",'Admin\SeriesController@create')->name('series-form');
    Route::get("/admin/serije/forma-izmena/{id}/{cat}","Admin\SeriesController@edit")->name("series-one-render");
    Route::delete('/admin/serije/brisanje/{id}','Admin\SeriesController@destroy');
    Route::put('/admin/serije/izmena-info/{id}','Admin\SeriesController@updateInfo')->name('series-update-info');
    Route::put('/admin/serije/izmena-slike/{id}','Admin\SeriesController@updatePicture')->name('series-update-picture');
    Route::post('/admin/serije/unos','Admin\SeriesController@store')->name('series-insert');

    Route::get('/admin/izvestaj','Admin\ActivityController@index')->name('activity');


});
