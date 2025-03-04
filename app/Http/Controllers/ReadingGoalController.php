<?php

namespace App\Http\Controllers;

use App\Models\ReadingGoal;
use App\Models\Tag;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class ReadingGoalController extends Controller
{
    public function index()
    {
        $readingGoals = ReadingGoal::where('user_id', Auth::id())->with('tags')->get();

        return Inertia::render('ReadingGoals/Index', [
            'readingGoals' => $readingGoals,
        ]);
    }

    public function create()
    {
        return Inertia::render('ReadingGoals/Create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'tags' => 'nullable|array',
        ]);

        $readingGoal = ReadingGoal::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
        ]);


        // Create tags
        if ($request->has('tags')) {
            foreach ($request->input('tags') as $tag) {
                Tag::create([
                    'reading_goal_id' => $readingGoal->id,
                    'name' => $tag['text'],
                ]);
            }
        }

        return redirect()->route('reading-goals.index');
    }

    public function edit(ReadingGoal $readingGoal)
    {
        // Ensure the user owns the reading goal
        if ($readingGoal->user_id !== Auth::id()) {
            abort(403);
        }

        return Inertia::render('ReadingGoals/Edit', [
            'readingGoal' => $readingGoal,
        ]);
    }

    public function update(Request $request, ReadingGoal $readingGoal)
    {
        // Ensure the user owns the reading goal
        if ($readingGoal->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $readingGoal->update([
            'name' => $request->name,
        ]);

        // Update tags
        $existingTagIds = $readingGoal->tags()->pluck('id')->toArray();
        $newTagIds = [];

        if ($request->has('tags')) {
            foreach ($request->input('tags') as $tag) {
                $existingTag = Tag::where('reading_goal_id', $readingGoal->id)->where('name', $tag)->first();

                if ($existingTag) {
                    $newTagIds= $existingTag->id;
                } else {
                    $newTag = Tag::create([
                        'reading_goal_id' => $readingGoal->id,
                        'name' => $tag,
                    ]);
                    $newTagIds= $newTag->id;
                }
            }
        }

        // Remove tags that are not present in the request
        $tagsToRemove = array_diff($existingTagIds, $newTagIds);
        Tag::whereIn('id', $tagsToRemove)->delete();

        return redirect()->route('reading-goals.index');
    }

    public function delete(ReadingGoal $readingGoal)
    {
        $readingGoal->delete();
        return redirect()->route('reading-goals.index');
    }
}
