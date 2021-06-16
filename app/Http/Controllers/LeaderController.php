<?php

namespace App\Http\Controllers;

use App\Models\Leaderboard;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use PHPUnit\Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

/**
 * Class LeaderController
 * @package App\Http\Controllers
 */
class LeaderController extends Controller
{
    /**
     * @return Leaderboard[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return Leaderboard::all();
    }

    /**
     * @return Leaderboard[]|\Illuminate\Database\Eloquent\Collection
     */
    public function order()
    {
        return Leaderboard::all()->sortByDesc("points");
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
            return response()->json(['Leader No.' . $id . ' does not exist'], 200);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function create(Request $request): JsonResponse
    {
        $data = $request->all();
        $validation = $this->validateNewLeaderInfo($request->all());
        if (!$validation['result']) {
            return response()->json([$validation['message']], 200);
        }
        $data['points'] = 0;
        try {
            Leaderboard::create($data);
            $message = "Leader " . $data['name'] . " has been created.";
            return response()->json([$message], 200);
        } catch(Exception $exception) {
            return response()->json([$exception->getMessage()], $exception->getCode());
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function increase($id): JsonResponse
    {
        try {
            $leader = Leaderboard::findOrFail($id);
            $leader->points++;
            $leader->save();
            $message = "The points of Leader " . $leader->name . " has been increased by 1, equals to " . $leader->points;
            return response()->json([$message], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['Increasing failed, No.' . $id . ' does not exist.'], 200);
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function decrease($id): JsonResponse
    {
        try {
            $leader = Leaderboard::findOrFail($id);
            if ($leader->points > 0) {
                $leader->points--;
                $leader->save();
                $message = "The points of Leader " . $leader->name . " has been decreased by 1, equals to " . $leader->points;
            } else {
                $message = "The points of Leader " . $leader->name . " is zero, can not be decreased any more.";
            }
            return response()->json([$message], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['Decreasing failed, No.' . $id . ' does not exist.'], 200);
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    public function delete($id): JsonResponse
    {
        try {
            $leader = Leaderboard::findOrFail($id);
            $name = $leader->name;
            $leader->delete();
            $message = $name . ' has been deleted from leaderboard.';
            return response()->json([$message], 200);
        } catch (ModelNotFoundException $exception) {
            return response()->json(['Deleting failed, No.'. $id .' does not exist.'], 200);
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $validation = $this->validateUpdateLeaderInfo($request->all());
        if (!$validation['result']) {
            return response()->json([$validation['message']], 200);
        }
        try {
            $leader = Leaderboard::findOrFail($id);
            $leader->fill($request->all())->save();
            $message = 'Leader No.' . $id . ' has been updated.';
            return response()->json([$message], 200);
        } catch(Exception $exception) {
            return response()->json([$exception->getMessage()], 200);
        }
    }

    /**
     * @param $data
     * @return array|bool[]
     */
    protected function validateNewLeaderInfo($data): array
    {
        $keys = ['name', 'age', 'address'];
        foreach ($keys as $key) {
            if (!key_exists($key, $data)) {
                return [
                    'result' => false,
                    'message' => 'Creation failed, ' . $key . ' is a required field.'
                ];
            }
        }
        return [
            'result' => true
        ];
    }

    /**
     * @param $data
     * @return array|bool[]
     */
    protected function validateUpdateLeaderInfo($data): array
    {
        $keys = ['name', 'age', 'points', 'address'];
        $inputKeys = array_keys($data);
        foreach ($inputKeys as $key) {
            if (!in_array($key, $keys)) {
                return [
                    'result' => false,
                    'message' => 'Update failed, ' . $key . ' is not a required field.'
                ];
            }
        }
        return [
            'result' => true
        ];
    }
}
