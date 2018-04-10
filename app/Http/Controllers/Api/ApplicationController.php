<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\User;
use App\Offer;
use App\ChatRoom;
use App\Application;
use App\Student\Document;

class ApplicationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index($offer_id)
    {
        $user = Auth::user();
        $offer = Offer::findOrFail($offer_id);

        if ($user->can('applications', $offer)) {
            $offer->organization;
            $offer->applications;
            return $offer;
        }

        return response('Not authorized', 403);
    }

    public function show($offer_id, $application_id)
    {
        $user = Auth::user();
        $offer = Offer::findOrFail($offer_id);

        if ($user->can('applications', $offer)) {
            $application = Application::findOrFail($application_id);

            if ($user->can('see', $application)) {
                $offer->organization;
                $application->documents;
                $application->student;

                return $application;
            }
        }

        return response('Not authorized', 403);
    }

    public function store(Request $request, $offer_id)
    {
        $user = Auth::user();
        $offer = Offer::findOrFail($offer_id);

        if ($user->can('applications', $offer)) {
            if ($user->can('create', Application::class)) {
                $this->validate($request, [
                    'new_cv' => 'nullable|file|max:2048',
                    'cover_letter' => 'nullable|file|max:2048',
                    'message' => 'reqired|string',
                ]);

                if ($request->new_cv) {
                    $cv = new Document;

                    $cv->path = $request->file('new_cv')->store("user/$user->id");
                    $cv->type = 'cv';

                    $user->documents()->save($cv);
                } else {
                    if ($user->documents->contains('type', 'cv')) {
                        $cv = $user->documents->where('type', 'cv');
                    }
                    return response('El cv es requerido', 422);
                }

                $application = new Application;

                $application->offer_id = $offer_id;
                $user->applications()->save($application);

                $application->documents()->save($cv);

                if ($request->cover_letter) {
                    $cover = new Document;

                    $cover->path = $request->file('cover_letter')->store("user/$user->id");
                    $cover->type = 'cover_letter';

                    $application->documents()->save($cover);
                }

                return $application;
            }
        }

        return response('Not authorized', 403);
    }

    public function update(Request $request, $offer_id, $application_id)
    {
        $user = Auth::user();
        $offer = Offer::findOrFail($offer_id);

        if ($user->can('applications', $offer)) {
            $application = Application::findOrFail($application_id);

            if ($user->can('update', $application)) {
                $this->validate($request, [

                ]);
            }
        }

        return response('Not authorized', 403);
    }

    public function delete($offer_id, $application_id)
    {
        $user = Auth::user();
        $offer = Offer::findOrFail($offer_id);

        if ($user->can('applications', $offer)) {
            $application = Application::findOrFail($application_id);

            if ($user->can('delete', $application)) {
                $application->delete();
                return response('Application deleted', 200);
            }
        }

        return response('Not authorized', 403);
    }

    // public function update_documents (Request $request, $offer_id, $application_id, $document_id) {

    // 	$user = Auth::user();
    // 	$offer = Offer::findOrFail($offer_id);

    // 	if ($user->can('applications', $offer)) {

    // 		$application = Application::findOrFail($application_id);

    // 		if ($user->can('update', $application)) {
                
    // 			$document = Document::findOrFail($document_id);

    // 			if ($user->can('update', $document)) {

    // 				$this->validate($request, [
    // 					'type' => 'required|string|max:255',
    // 					'payload' => 'required|document|max:5120',
    // 				]);

    // 				// Delte last document
    // 				Storage::delete($document->path);

    // 				// Upload new document
    // 				$document->type = $request->type;
    // 				$document->path = $request->file('payload')->store("applications/$application->id");
    // 				$document->save();

    // 				return response ('File uploaded', 200);

    // 			}

    // 		}

    // 	}

    // 	return response ('Not authorized', 403);

    // }
}
