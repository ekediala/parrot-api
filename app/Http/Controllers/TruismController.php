<?php

namespace App\Http\Controllers;

use App\Truism;
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
            'seenBy' => [],
            'interactions' => [],
        ]);

        $response = ['status' => $status];

        if (!$status) {
            return response()->json($response, 500);
        }

        return response()->json($response, 200);

    }

    /**
     * Display a given truism.
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $truisms = Truism::all();
        shuffle($truisms);
        foreach ($truisms as $truism) {
            if (!in_array($id, $truism->seenBy)) {
                $unseen = $truism;
                $seenBy = $truism->seenBy;
                array_push($seenBy, $id);
                $truism->seenBy = $seenBy;
                $truism->save();
                break;
            }
        }
        if (!isset($unseen)){
            $max = count($truisms) - 1;
            $unseen = $truisms[random_int(0, $max)];
        }

        return response()->json($unseen, 200);
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
        request()->validate([
            'userId' => 'required',
            'truismId' => 'required',
            'interactionType' => 'required'
        ]);
        $user_id = request()->userId;
        $truism_id = request()->truismId;
        $interaction_type = request()->interactionType;
        $truism = Truism::where('id', $truism_id)->lockForUpdate()->firstOrFail();
        $interactions = $truism->interactions;
        if (array_key_exists($user_id, $interactions)) {
            $interacted = $interactions[$user_id];
            if ($interacted == 'meh' && $truism->meh > 0) {
                $truism->decrement('meh');
            } else if ($truism->haha > 0 && $interacted == 'haha'){
                $truism->decrement('haha');
            }
            unset($interactions[$user_id]);
            $truism->interactions = $interactions;
            $truism->save();
            return response()->json($truism, 200);
        }
        if ($interaction_type == 'meh') {
            $truism->increment('meh');
        } else {
            $truism->increment('haha');
        }
        $interactions[$user_id] = $interaction_type;
        $truism->interactions = $interactions;
        $truism->save();
        return response()->json($truism, 200);

    }
}
