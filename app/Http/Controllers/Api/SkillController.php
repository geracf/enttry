<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SkillController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return [
            'languages' => $user->skills->where('type', 'language')->values(),
            'tech_skills' => $user->skills->where('type', 'technical')->values(),
            'soft_skills' => $user->skills->where('type', 'soft')->values(),
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:language,technical,soft',
            'development' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();

        if ($user->can('create', Skill::class)) {
            $skill = Skill::make($request->all());
            $user->skills()->save($skill);
            return [
                'created' => 'ok'
            ];
        }
        return response('Not authorized', 403);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::user();
        $skill = Skill::findOrFail($id);

        if ($user->can('delete', $skill)) {
            $skill->delete();
            return [
                'deleted' => 'ok'
            ];
        }
        return response('Not authorized', 403);
    }
}
