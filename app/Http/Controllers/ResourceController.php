<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Position;
use App\Models\User;
use App\Models\UserApi;
use App\Services\TinifyImageOptimization;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ResourceController extends Controller
{
    public function indexAction(Request $request): JsonResponse
    {
        $count = $request->input('count', 6);

        $users = UserApi::orderBy('updated_at', 'desc')->orderBy('name', 'asc')->paginate($count);
        if(!$users){
            return response()->json([
                'success' => false,
                'message' => 'No users found',
            ], 404);
        }

        $response = [
            'success' => true,
            'page' => $users->currentPage(),
            'total_pages' => $users->lastPage(),
            'total_users' => $users->total(),
            'count' => $users->count(),
            'links' => [
                'next_url' => $users->nextPageUrl(),
                'prev_url' => $users->previousPageUrl(),
            ],
            'users' => $users->items(),
        ];

        return response()->json($response);
    }
    public function showAction(Request $request, string $id): JsonResponse{
        $user = UserApi::findOrFail($id);
        $response = [
            'success' => true,
            'user' => $user,
        ];
        return response()->json($response);
    }

    public function showPositionsAction(Request $request): JsonResponse{
        $response = [
            'success' => true,
            'positions' => Position::all(),
        ];
        return response()->json($response);
    }
    public function storeAction(Request $request, TinifyImageOptimization $imageOptimization): JsonResponse
    {

        $validatedData = $request->validate([
            'name' => 'required|string|min:2|max:60',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|regex:/^(\+?\d{1,3}[ .-]?)?(\(?\d{1,4}\)?[ .-]?)?[\d .-]{7,10}$/|unique:users,phone',
            'position_id' => 'required|exists:positions,id',
            'photo' => 'required|file|mimes:jpeg,jpg,png|max:5120',
        ]);

        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $filename = Str::uuid() . '.' . $photo->getClientOriginalExtension();
            $imageOptimization->profilePictureOptimizationAction($photo->get(), public_path('images/users/') . $filename);
            $photoPath = 'images/users/' . $filename;
        }

        $user = new User();
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        $user->phone = $validatedData['phone'];
        $user->position_id = $validatedData['position_id'];
        $user->photo = $photoPath ?? null;
        $user->save();

        return response()->json(['success' => true, 'user_id' => $user->id, 'message' => 'New user successfully registered'], 201);
    }

}
