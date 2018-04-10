<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\User;
use App\Student\Document;

class DocumentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
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
            'document' => 'required|file|max:2048',
            'document_type' => 'required|string|in:cv,aknowledgment',
        ]);

        $user = Auth::user();

        if ($user->can('create', Document::class)) {
            $document = new Document;

            $document->path = $request->file('document')->store("user/$user->id");
            $document->type = $request->document_type;

            $user->documents()->save($document);

            $document->path = $document->url();
            return $document;
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
        $user = Auth::user();
        $document = Document::findOrFail($id);

        if ($user->can('view', $document)) {
            $document->path = $document->url();
            return $document;
        }

        return response('Not authorized', 403);
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
        $this->validate($request, [
            'document' => 'required|file|max:2048',
        ]);

        $user = Auth::user();
        $document = Document::findOrFail($id);

        if ($user->can('update', $document)) {
            if ($document->path) {
                Storage::delete($document->path);
            }
            $document->path = $request->file('document')->store("user/$user->id");

            $document->save();

            return $document;
        }

        return response('Not authorized', 403);
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
        $document = Document::findOrFail($id);

        if ($user->can('delete', $document)) {
            $document->delete();
            $response = ['id' => $document->id, 'deleted_url' => $document->url, 'status' => 'deleted'];

            return $response;
        }

        return response('Not authorized', 403);
    }
}
