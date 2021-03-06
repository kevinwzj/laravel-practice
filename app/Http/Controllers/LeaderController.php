<?php

namespace App\Http\Controllers;

use App\Models\Leaderboard;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use PHPUnit\Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Validator;

/**
 * Class LeaderController
 * @package App\Http\Controllers
 */
class LeaderController extends Controller
{
    const SUCCESS_STATUS_CODE = 200;
    const BAD_REQUEST_STATUS_CODE = 400;
    const NO_FOUND_STATUS_CODE = 404;

    /**
     * @return Leaderboard[]|Collection
     */
    public function index()
    {
        return Leaderboard::all();
    }

    /**
     * @return mixed
     */
    public function order()
    {
        return Leaderboard::orderBy("points", 'DESC')->orderBy("id", 'ASC')->get();
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function show($id)
    {
        try {
            return Leaderboard::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            $message = 'Leader No.' . $id . ' does not exist';
            return response()->json(['message' => $message], self::NO_FOUND_STATUS_CODE);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:leaderboard',
            'age' => 'required|integer',
            'address' => 'required'
        ]);
        if ($validator->fails()) {
            return response()
                ->json(
                    ['message' => 'Creation failed: ' . $validator->errors()->first()],
                    self::BAD_REQUEST_STATUS_CODE
                );
        }
        $data = $request->all();
        $data['points'] = 0;
        try {
            Leaderboard::create($data);
            $message = "Leader " . $data['name'] . " has been created.";
            return response()->json(['message' => $message], self::SUCCESS_STATUS_CODE);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], self::BAD_REQUEST_STATUS_CODE);
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function increase($id): JsonResponse
    {
        try {
            $leader = Leaderboard::find($id);
            if (empty($leader->id)) {
                $message = 'Increasing failed, No.' . $id . ' does not exist.';
                return response()->json(['message' => $message], self::NO_FOUND_STATUS_CODE);
            }
            $leader->points++;
            $leader->save();
            $message = "The points of Leader " . $leader->name . " has been increased by 1, equals to "
                . $leader->points;
            return response()->json(['message' => $message], self::SUCCESS_STATUS_CODE);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], self::BAD_REQUEST_STATUS_CODE);
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function decrease($id): JsonResponse
    {
        try {
            $leader = Leaderboard::find($id);
            if (empty($leader->id)) {
                $message = 'Decreasing failed, No.' . $id . ' does not exist.';
                return response()->json(['message' => $message], self::NO_FOUND_STATUS_CODE);
            }
            if ($leader->points > 0) {
                $leader->points--;
                $leader->save();
                $message = "The points of Leader " . $leader->name . " has been decreased by 1, equals to "
                    . $leader->points;
            } else {
                $message = "The points of Leader " . $leader->name . " is zero, can not be decreased any more.";
            }
            return response()->json(['message' => $message], self::SUCCESS_STATUS_CODE);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], self::NO_FOUND_STATUS_CODE);
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        try {
            $leader = Leaderboard::find($id);
            if (empty($leader)) {
                $message = 'Deleting failed, No.'. $id .' does not exist.';
                return response()->json(['message' => $message], self::NO_FOUND_STATUS_CODE);
            }
            $name = $leader->name;
            $leader->delete();
            $message = $name . ' has been deleted from leaderboard.';
            return response()->json(['message' => $message], self::SUCCESS_STATUS_CODE);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], self::NO_FOUND_STATUS_CODE);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'age' => 'required|integer',
            'points' => 'required|integer',
            'address' => 'required'
        ]);
        if ($validator->fails()) {
            return response()
                ->json(
                    ['message' => 'Updated failed: ' . $validator->errors()->first()],
                    self::BAD_REQUEST_STATUS_CODE
                );
        }
        try {
            $leader = Leaderboard::find($id);
            if (empty($leader->id)) {
                $message = 'Updating failed, No.'. $id .' does not exist.';
                return response()->json(['message' => $message], self::NO_FOUND_STATUS_CODE);
            }
            $leader->fill($request->all())->save();
            $message = 'Leader No.' . $id . ' has been updated.';
            return response()->json(['message' => $message], self::SUCCESS_STATUS_CODE);
        } catch (Exception $exception) {
            return response()->json(['message' => $exception->getMessage()], self::BAD_REQUEST_STATUS_CODE);
        }
    }
}
