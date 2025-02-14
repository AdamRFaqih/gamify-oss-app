<?php

namespace App\Http\Controllers;

use App\Models\Quest;
use Illuminate\Http\Request;
use Inertia\Inertia;


class QuestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Dashboard', [
            'quests' => Quest::all(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'issue_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'role_dev' => 'required',
            'difficulty' => 'required',
            'required_level' => 'required',
            'proficiency_reward' => 'required',
            'experience_reward' => 'required',
            'status' => 'required',
        ]);
        Quest::create($validated);
        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     */
    public function show(Quest $quest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quest $quest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Quest $quest)
    {
        $validated= $request->validate([
            'issue_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'role_dev' => 'required',
            'difficulty' => 'required',
            'required_level' => 'required',
            'proficiency_reward' => 'required',
            'experience_reward' => 'required',
            'status' => 'required',
        ]);
        $quest->update($validated);
        return redirect()->route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quest $quest)
    {
        $quest->delete();
        return redirect()->route('dashboard');
    }
}
