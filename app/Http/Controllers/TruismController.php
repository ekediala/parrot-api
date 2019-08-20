<?php

namespace App\Http\Controllers;

use App\Truism;
use App\User;
use Faker\Generator as Faker;
use Illuminate\Http\Request;

class TruismController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Truism::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'author' => 'required',
            'truism' => 'required',
        ]);

        $status = Truism::create([
            'author' => $request->author,
            'truism' => $request->truism,
        ]);

        $response = ['status' => $status];

        if (!status) {
            return response()->json($response, 500);
        }

        return response()->json($response, 200);

    }

    /**
     * Display a given truism.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Faker $faker)
    {
        if (!auth()->check()) {
            $user = new User;
            $user->email = $faker->safeEmail;
            $user->password = bcrypt('password');
            $user->name = $faker->name();
            $user->save();
            auth()->login($user, true);
        }
        if (!request()->session()->has('seen')) {
            request()->session()->put('seen', []);
        }
        $truisms = Truism::all();
        $seen = request()->session()->get('seen');
        $unseen = $truisms->diff(Truism::whereIn('id', $seen)->get());
        if (count($unseen) < 1) {
            $unseen = $truisms;
        }
        $truism = $unseen[random_int(0, count($unseen))];
        request()->session()->push('seen', $truism->id);
        return response()->json(['response' => $truism], 200);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Truism  $truism
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Truism $truism)
    {
        $request->validate([
            $request->author => 'required',
            $request->truism => 'required',
        ]);
        $status = $truism->update([
            'author' => $request->author,
            'truism' => $request->truism,
        ]);

        $response = ['status' => $status];

        if (!status) {
            return response()->json($response, 500);
        }

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Truism  $truism
     * @return \Illuminate\Http\Response
     */
    public function destroy(Truism $truism)
    {
        $status = $truism->delete();
        $response = ['status' => $status];

        if (!status) {
            return response()->json($response, 500);
        }

        return response()->json($response, 200);

    }

    public function interact()
    {
        $user_id = auth()->user()->id();
        $truism_id = request()->truism_id;
        $interaction_type = request()->interaction_type;
        $truism = Truism::findOrFail($truism_id);
        $interactions = $truism->interactions;
        if (array_key_exists($user_id, $interactions)) {
            $interacted = $interactions[$user_id];
            if ($interacted == 'meh') {
                $truism->decrement('meh');
            } else {
                $truism->decrement('haha');
            }
            return response()->json($truism, 200);

        }
        if ($interaction_type == 'meh') {
            $truism->increment('meh');
        }
        $truism->increment('haha');
        $interactions[$user_id] = $interaction_type;
        $truism->interactions = $interactions;
        $truism->save();
        return response()->json($truism, 200);

    }
}
