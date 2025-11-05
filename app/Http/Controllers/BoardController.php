<?php

namespace App\Http\Controllers;

use App\Models\Board;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller as BaseController;

class BoardController extends BaseController
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index()
    {
        $user = Auth::user();

        $boards = Board::with('tasks')
            ->where('status', 'active')
            ->get()
            ->filter(fn($board) => $user->can('view', $board))
            ->values();

        return response()->json([
            'message' => 'Boards fetched successfully',
            'boards' => $boards
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $board = Board::create([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'created_by' => Auth::id(),
            'status' => 'active',
        ]);

        return response()->json([
            'message' => 'Board created successfully',
            'board' => $board
        ], 201);
    }


    public function show(Board $board)
    {
        $this->authorize('view', $board);

        $board->load('tasks');

        return response()->json([
            'message' => 'Board fetched successfully',
            'board' => $board
        ]);
    }


    public function update(Request $request, Board $board)
    {
        $this->authorize('update', $board);

        $validated = $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'status' => 'sometimes|in:active,archived',
        ]);

        $board->update($validated);

        return response()->json([
            'message' => 'Board updated successfully',
            'board' => $board
        ]);
    }

    public function destroy(Board $board)
    {
        $this->authorize('delete', $board);

        $board->update(['status' => 'archived']);

        return response()->json([
            'message' => 'Board archived successfully'
        ]);
    }
}
