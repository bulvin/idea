<?php

declare(strict_types=1);

use App\Http\Controllers\IdeaController;
use App\Http\Controllers\IdeaImageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisteredUserController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\ShareIdeaController;
use App\Http\Controllers\ShowSharedIdeaController;
use App\Http\Controllers\StepController;
use Illuminate\Support\Facades\Route;

Route::redirect("/", "/ideas");

Route::get("/ideas/preview/{code}", ShowSharedIdeaController::class)->name(
    "ideas.shared.show",
);

Route::middleware("guest")->group(function () {
    Route::get("/register", [RegisteredUserController::class, "create"]);
    Route::post("/register", [RegisteredUserController::class, "store"]);

    Route::get("/login", [SessionsController::class, "create"])->name("login");
    Route::post("/login", [SessionsController::class, "store"]);
});

Route::middleware("auth")->group(function () {
    Route::get("/ideas", [IdeaController::class, "index"])->name("ideas.index");

    Route::post("/ideas", [IdeaController::class, "store"])->name(
        "ideas.store",
    );

    Route::get("/ideas/{idea}", [IdeaController::class, "show"])->name(
        "ideas.show",
    );

    Route::patch("/ideas/{idea}", [IdeaController::class, "update"])->name(
        "ideas.update",
    );

    Route::delete("/ideas/{idea}", [IdeaController::class, "destroy"])->name(
        "ideas.destroy",
    );

    Route::delete("/ideas/{idea}/image", [
        IdeaImageController::class,
        "destroy",
    ])->name("ideas.image.destroy");

    Route::post("/ideas/{idea}/code", ShareIdeaController::class)->name(
        "ideas.share",
    );

    Route::patch("/steps/{step}", [StepController::class, "update"])->name(
        "steps.update",
    );

    Route::post("/logout", [SessionsController::class, "destroy"]);

    Route::get("/profile", [ProfileController::class, "edit"])->name(
        "profile.edit",
    );

    Route::patch("/profile", [ProfileController::class, "update"])->name(
        "profile.update",
    );
});
