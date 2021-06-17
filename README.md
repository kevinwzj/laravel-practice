# Create an API for leaderboard application

A simple example of Leaderboard with a RESTful API in Laravel Framework 8.46.0 and PHP 7.4.20

## Endpoints

**1. Sort all leaders by points:**

`GET /api/user/leaderboard/order`
<pre>
Response json data sample:
[
    {
        "id": 3,
        "name": "Tim",
        "age": "26",
        "points": 8,
        "address": "1618 29 ST Surrey V7E 8R2",
        "created_at": "2021-06-16T21:47:07.000000Z",
        "updated_at": "2021-06-16T22:27:22.000000Z"
    },
    {
        "id": 2,
        "name": "Kevin",
        "age": "32",
        "points": 5,
        "address": "16409 25 ST Surrey V6E 8E3",
        "created_at": "2021-06-16T21:46:31.000000Z",
        "updated_at": "2021-06-16T21:47:00.000000Z"
    }
]
</pre>

**2. Get a single leader by id:**

`GET /api/user/leaderboard/{id}`

<pre>
Response json data sample:
[
    {
        "id": 3,
        "name": "Tim",
        "age": "26",
        "points": 8,
        "address": "1618 29 ST Surrey V7E 8R2",
        "created_at": "2021-06-16T21:47:07.000000Z",
        "updated_at": "2021-06-16T22:27:22.000000Z"
    }
]
</pre>

**3. Create a new leader:**

`POST /api/user/leaderboard`
<pre>
Request json data sample:
{
    "name": "Mike",
    "age": 26,
    "address": "1657 27 ST Surrey V3E 8R2"
}
</pre>

<pre>
Response json data sample:
{
    "message": "Leader Mike has been created."
}
</pre>

**4. Increase one point for a leader:**

`POST /api/user/leaderboard/increase/{id}`

<pre>
Response json data sample:
{
    "message": "The points of Leader Tim has been increased by 1, equals to 8"
}
</pre>

**5. Decrease one point for a leader:**

`POST /api/user/leaderboard/decrease/{id}`

<pre>
Response json data sample:
{
    "message": "The points of Leader Tim has been decreased by 1, equals to 3"
}
</pre>

**6. Delete a leader:**

`DELETE /api/user/leaderboard/{id}`

<pre>
Response json data sample:
{
    "message": "Kevin has been deleted from leaderboard."
}
</pre>

**7. Update a leader:**

`PUT /api/user/leaderboard/{id}`
<pre>
Request json data sample:
{
    "name": "Mike Carter",
    "age": 28,
    "points": 5,
    "address": "1356 160 ST Surrey V5E 6R3"
}
</pre>

<pre>
Response json data sample:
[
    "Leader No.2 has been updated."
]
</pre>

**Note:**

`Use this IP for testing purpose: 54.164.156.234`

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

## Laravel artisan commands

```
php artisan migrate
php artisan test tests/Feature/Http/Controllers/LeaderControllerTest.php
```

## Main contributions

```
1. Miagraton: database/migrations/2021_06_14_225630_create_leaderboard_table.php
2. Route: routes/api.php
3. Model: app/Models/Leaderboard.php
4. Controller: app/Http/Controllers/LeaderController.php
5. Test: tests/Feature/Http/Controllers/LeaderControllerTest.php
6. Readme: README.md
```

## Postman collection
[Leaderboard Postman Collection download link](https://drive.google.com/file/d/1Hc_sp7ezLi8JcKU75Cc5NpqDzfpfhETe/view?usp=sharing)
