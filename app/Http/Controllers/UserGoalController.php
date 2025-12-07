<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserGoal;
use Illuminate\Support\Facades\Auth;

class UserGoalController extends Controller
{
    /**
     * List all goals of logged-in user
     */
    public function index()
    {
        $goals = Auth::user()->goals()->get();
        return view('user_goals.index', compact('goals'));
    }

    /**
     * Show form to create a new goal
     */
    public function create()
    {
        $nutrients = ['calories', 'protein', 'carbs', 'fat', 'fiber'];
        return view('user_goals.create', compact('nutrients'));
    }

    /**
     * Store a new goal
     */
    public function store(Request $request)
    {
        $request->validate([
            'nutrient' => 'required|string',
            'target_value' => 'required|numeric|min:0',
            'unit' => 'nullable|string',
            'direction' => 'required|in:min,max',
            'period' => 'required|in:day,week',
            'weight' => 'nullable|numeric|min:0.1',
        ]);

        UserGoal::create([
            'user_id' => Auth::id(),
            'nutrient' => $request->nutrient,
            'target_value' => $request->target_value,
            'unit' => $request->unit ?? null,
            'direction' => $request->direction,
            'period' => $request->period,
            'weight' => $request->weight ?? 1,
            'active' => true,
        ]);

        return redirect()->route('user_goals.index')->with('success', 'Goal added successfully!');
    }

    /**
     * Mark a goal as inactive
     */
    public function deactivate(UserGoal $userGoal)
    {
        if ($userGoal->user_id != Auth::id()) {
            abort(403);
        }

        $userGoal->update(['active' => false]);

        return redirect()->route('user_goals.index')->with('success', 'Goal deactivated.');
    }
}
