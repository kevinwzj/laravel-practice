# Create an API for leaderboard application

A simple example of Leaderboard with a RESTful API in Laravel Framework 8.46.0 and PHP 7.4.20

## Endpoints

**Get all leaders:** `GET /api/user/leaderboard`

**Sort all leaders by points:** `GET /api/user/leaderboard/order`

**Get a single leader by id:** `GET /api/user/leaderboard/{id}`

**Create a new leader:** `POST /api/user/leaderboard`

**Increase one point for a leader:** `POST /api/user/leaderboard/increase/{id}`

**Decrease one point for a leader:** `POST /api/user/leaderboard/decrease/{id}`

**Delete a leader:** `DELETE /api/user/leaderboard/{id}`

**Update a leader:** `PUT /api/user/leaderboard/{id}`

## Routes

```
Route::prefix('user')->group(function () {
    Route::get('leaderboard', [LeaderController::class,'index']);
    Route::get('leaderboard/order', [LeaderController::class,'order']);
    Route::get('leaderboard/{id}', [LeaderController::class,'show']);
    Route::post('leaderboard', [LeaderController::class,'create']);
    Route::post('leaderboard/increase', [LeaderController::class,'increase']);
    Route::post('leaderboard/decrease', [LeaderController::class,'decrease']);
    Route::delete('leaderboard/{id}', [LeaderController::class,'delete']);
    Route::put('leaderboard/{id}', [LeaderController::class,'update']);
});
```

### Laravel artisan commands

```
php artisan migrate
php artisan test 
```
