<?php

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\NoteController;
use Illuminate\Support\Facades\Route;

Route::get('/',[WelcomeController::class,'welcome'] )->name('welcome');

//Route::get('/note',[NoteController::class,'index'])->name('note.index');
//Route::post('/note/create',[NoteController::class,'create'])->name('note.create');
//Route::get('/note',[NoteController::class,'store'])->name('note.store');
//Route::get('/note/{id}',[NoteController::class,'show'])->name('note.show');
//Route::get('/note/{id}/edit',[NoteController::class,'edit'])->name('note.edit');
//Route::put('/note/{id}',[NoteController::class,'update'])->name('note.update');
//Route::delete('/note/{id}',[NoteController::class,'destroy'])->name('note.destroy');

Route::resource('note',NoteController::class);