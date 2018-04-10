<?php

namespace App\Http\Controllers\Web;

use App\Answer;
use App\ChatRoom;
use App\Http\Controllers\Controller;
use App\Offer;
use App\Question;
use App\Requirement;
use App\Student\Application;
use App\Traits\UsesPictures;
use App\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OfferController extends Controller
{

    use UsesPictures;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show($offer_id)
    {
        $user = Auth::user();
        $offer = Offer::findOrFail($offer_id);
        // $offer->prepareJson($user);

        if ($user->can('view', $offer)) {
            if ($user->isStudent()) {
                $offer->view_count += 1;
                $offer->save();
            }
            return view('offers.show', [
                'offer' => $offer,
            ]);
        }

        return back();
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->can('create', Offer::class)) {
            $organization = $user->organization;
            $this->validate($request, [
                'name' => 'required|string|max:255',
                'category' => 'required|string|max:255',
                'type' => 'required|string|max:255',
                'desc' => 'nullable|string',
                'salary' => 'nullable|string|max:255',
                'location' => 'nullable|string|max:255',
                'show_location' => 'required|boolean',
                'lat' => 'nullable|required_with:lng|numeric',
                'lng' => 'nullable|required_with:lat|numeric',
                'remote' => 'required|boolean',
                'pictures' => 'nullable|array|min:1',
                'pictures.*' => 'required|image|max:2048',
                'looking_for' => 'required|string'
            ]);

            // dd($request->all());

            $offer = new Offer;

            $offer->name = $request->name;
            $offer->category = $request->category;
            $offer->type = $request->type;
            $offer->desc = $request->desc;
            $offer->salary = $request->salary;
            $offer->location = $request->location;
            $offer->show_location = $request->show_location;
            $offer->lat = $request->lat;
            $offer->lng = $request->lng;
            $offer->remote = $request->remote;
            $offer->looking_for = $request->looking_for;

            $organization->offers()->save($offer);

            if ($request->pictures) {
                $this->addMany($offer, $request->pictures, "offers/$offer->id");
            }

            if ($request->requirements) {
                foreach ($request->requirements as $r) {
                    $requirement = new Requirement;

                    $requirement->text = $r;
                    $requirement->mandatory = true;
                    $requirement->nice_to_have = true;

                    $offer->requirements()->save($requirement);
                }
            }

            if ($request->question) {
                foreach ($request->question as $q) {
                    if ($q != null) {
                        $question = new Question;
                        $question->text = $q;
                        $question->required = true;

                        $offer->questions()->save($question);
                    }
                }
            }

            $organization->remaining_offers -= 1;
            $organization->save();

            return back()->with('success', 'Offer added');
        }
    }

    public function update(Request $request, $offer_id)
    {
        // dd($request->all());
        $user = Auth::user();
        $offer = Offer::findOrFail($offer_id);

        if ($user->can('update', $offer)) {
            $offer->name = $request->name;
            $offer->category = $request->category;
            $offer->type = $request->type;
            $offer->desc = $request->desc;
            $offer->salary = $request->salary;
            $offer->location = $request->location;
            $offer->show_location = $request->show_location;
            $offer->lat = $request->lat;
            $offer->lng = $request->lng;
            $offer->remote = $request->remote;

            $offer->save();

            if ($request->requirements) {
                if ($offer->requirements->count() > 0) {
                    $offer->requirements()->delete();
                }
                foreach ($request->requirements as $r) {
                    // dd($r);
                    $requirement = new Requirement;

                    $requirement->text = $r;
                    $requirement->mandatory = true;
                    $requirement->nice_to_have = true;

                    $offer->requirements()->save($requirement);
                }
            }

            if ($request->question) {
                if ($offer->questions->count() > 0) {
                    $offer->questions()->delete();
                }
                foreach ($request->question as $q) {
                    if ($q != null) {
                        $question = new Question;
                        $question->text = $q;
                        $question->required = true;

                        $offer->questions()->save($question);
                    }
                }
            }
        }

        return back();
    }

    public function apply(Request $request, $offer_id)
    {
        $user = Auth::user();
        $offer = Offer::findOrFail($offer_id);

        if ($user->can('apply', $offer)) {
            $application = new Application;

            $application->user_id = $user->id;
            $offer->applications()->save($application);

            if (count($request->answers) > 0) {
                foreach ($request->answers as $key => $answer) {
                    $question = Question::find($key);
                    $question_answer = new Answer;
                    $question_answer->text = $answer;
                    $question_answer->application_id = $application->id;
                    try {
                        $question->answers()->save($question_answer);
                    } catch (QueryException $e) {
                        $application->delete();
                        return back()->with('error', 'Por favor contesta las preguntas');
                    }
                }
            }

            $chat = new ChatRoom;
            $chat->user_id = $user->id;
            $application->chats()->save($chat);

            $subject = $offer->organization->creator;

            if ($subject instanceof User) {
                $subject->notify(new StudentApplied($user, $offer));
            }

            return back()->with("success", "¡Acabas de aplicar a esta oferta!");
        }

        return back()->with('error', "No puedes aplicar a esta oferta!");
    }
}
