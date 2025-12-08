<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserGoal;
use Illuminate\Support\Facades\Auth;

class UserGoalController extends Controller
{
    /**
     * Display a listing of the user's goals.
     */
    public function index()
    {
        $goals = Auth::user()->goals()->orderByDesc('created_at')->get();
        return view('user_goals.index', compact('goals'));
    }

    /**
     * Show the form for creating a new goal.
     */
    public function create()
    {
        // list of nutrients the user can choose from
        $nutrients = ['calories', 'protein', 'carbs', 'fat', 'fiber'];
        return view('user_goals.create', compact('nutrients'));
    }

    /**
     * Store a newly created goal in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nutrient' => 'required|string|in:calories,protein,carbs,fat,fiber',
            'target_value' => 'required|numeric|min:0',
            'unit' => 'nullable|string|max:10',
            'direction' => 'required|in:min,max',
            'period' => 'required|in:day,week',
            'weight' => 'nullable|numeric|min:0',
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
     * Deactivate a user's goal.
     */
    public function deactivate(UserGoal $userGoal)
    {
        // ensure the goal belongs to the logged-in user
        if ($userGoal->user_id !== Auth::id()) {
            abort(403);
        }

        $userGoal->update(['active' => false]);

        return redirect()->route('user_goals.index')->with('success', 'Goal deactivated.');
    }
public function edit(UserGoal $user_goal)
{
    $goals = UserGoal::where('user_id', auth()->id())->get();
    return view('user_goals.edit', compact('goals'));
}

public function update(Request $request)
{
    foreach ($request->goals as $id => $data) {
        $goal = UserGoal::find($id);
        if (!$goal) continue;

        $goal->target_value = $data['target_value'] ?? $goal->target_value;
        $goal->unit = $data['unit'] ?? $goal->unit;
        $goal->direction = $data['direction'] ?? $goal->direction;
        $goal->period = $data['period'] ?? $goal->period;
        $goal->weight = $data['weight'] ?? $goal->weight;
        $goal->active = isset($data['active']) ? true : false; // handle checkbox
        $goal->save();
    }

    return redirect()->route('user_goals.index')->with('success', 'Goals updated successfully.');
}



}
