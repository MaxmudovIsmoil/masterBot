<?php

namespace App\Http\Controllers;

use App\Http\Requests\GroupStoreRequest;
use App\Http\Requests\GroupUpdateRequest;
use App\Http\Resources\CabinetResource;
use App\Models\User;
use App\Models\Group;
use App\Services\GroupService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function __construct(
        private GroupService $service
    ) {}

    public function index()
    {
        $users = User::select('id', 'name')
            ->where(['role' => 3, 'status' => 1])
            ->whereNull('deleted_at')
            ->get()
            ->toArray();

        return view('group.index', compact('users'));
    }


    public function getGroups()
    {
        return $this->service->getGroups();
    }


    public function getOne(int $id): object
    {
        try {
            return response()->success($this->service->one($id));
        }
        catch (\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }

    public function store(GroupStoreRequest $request): JsonResponse
    {
        try {
            $user = $this->service->store($request->validated());
            return response()->success($user);
        }
        catch (\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }

    public function update(GroupUpdateRequest $request, int $id): JsonResponse
    {
        try {
            $result = $this->service->update($request->validated(), $id);
            return response()->success($result);
        }
        catch(\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }

    public function destroy(int $id): JsonResponse
    {
        try {
            return response()->success($this->service->destroy($id));
        }
        catch (\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }


    public function getCapitanPhone(int $userId): JsonResponse
    {
        try {
            $phone = User::findOrfail($userId)->phone;
            return response()->success($phone);
        }
        catch (\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }


    public function apiGroup(string $phone, string $chatId): JsonResponse
    {
        try {
            $group = Group::where('status', 1)->where('phone', $phone)->first();

            if ($group) {
                $group->update(['chatId' => $chatId]);
                return response()->success($group);
            } else {
                return response()->fail('Group not found');
            }
        } catch (\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }


    public function apiCabinet(string $chatId): JsonResponse
    {
        try {
            $group = Group::where('chatId', $chatId)->with('capitan')->first();

            return response()->success(new CabinetResource($group));

        } catch (\Exception $e) {
            return response()->fail($e->getMessage());
        }
    }

}
