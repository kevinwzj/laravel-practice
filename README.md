# Create an API for leaderboard application

A simple example of Leaderboard with a RESTful API in Laravel Framework 8.46.0 and PHP 7.4.20

## Endpoints

**1. Get all leaders:**

`GET /api/user/leaderboard`

**2. Sort all leaders by points:**

`GET /api/user/leaderboard/order`

**3. Get a single leader by id:**

`GET /api/user/leaderboard/{id}`

**4. Create a new leader:**

`POST /api/user/leaderboard`

*json data sample:*
```
{
    "name": "Mike",
    "age": 26,
    "address": "1657 27 ST Surrey V3E 8R2"
}
```

**5. Increase one point for a leader:**

`POST /api/user/leaderboard/increase/{id}`

**6. Decrease one point for a leader:**

`POST /api/user/leaderboard/decrease/{id}`

**7. Delete a leader:**

`DELETE /api/user/leaderboard/{id}`

**8. Update a leader:**

`PUT /api/user/leaderboard/{id}`

*json data sample:*
```
{
    "name": "Mike Carter",
    "age": 28,
    "points": 5,
    "address": "1356 160 ST Surrey V5E 6R3"
}
```

## Routes

```
Route::prefix('user')->group(function () {
    Route::get('leaderboard', [LeaderController::class,'index']);
    Route::get('leaderboard/order', [LeaderController::class,'order']);
    Route::get('leaderboard/{id}', [LeaderController::class,'show']);
    Route::post('leaderboard', [LeaderController::class,'create']);
    Route::post('leaderboard/increase/{id}', [LeaderController::class,'increase']);
    Route::post('leaderboard/decrease/{id}', [LeaderController::class,'decrease']);
    Route::delete('leaderboard/{id}', [LeaderController::class,'delete']);
    Route::put('leaderboard/{id}', [LeaderController::class,'update']);
});
```

### Laravel artisan commands

```
php artisan migrate
php artisan test 
```
