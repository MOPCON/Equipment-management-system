<?php

namespace App\Http\Controllers;

use App\User;
use App\Speaker;
use App\Http\Requests\SpeakerRequest;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class SpeakerController extends Controller
{
    use ApiTrait;
    use CheckPermissionTrait;

    /**
     * @param $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $order_field = $request->input('orderby_field', 'id');
        $order_method = $request->input('orderby_method', 'desc');
        if ($request->input('all', false)) {
            $speaker = Speaker::orderBy($order_field, $order_method)->get();
        } else {
            $limit = $request->input('limit', 15);
            $speaker = Speaker::Where(function ($query) use ($search) {
                $query->orWhere('name', 'LIKE', '%' . $search . '%')
                        ->orWhere('company', 'LIKE', '%' . $search . '%')
                        ->orWhere('topic', 'LIKE', '%' . $search . '%');
            })
                ->orderBy($order_field, $order_method)
                ->paginate($limit);
        }

        return $this->returnSuccess('Success.', $speaker);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  SpeakerRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(SpeakerRequest $request)
    {
        $data = $request->only(['name', 'speaker_type']);
        $data['last_edited_by'] = auth()->user()->name;
        $speaker = Speaker::create($data);

        return $this->returnSuccess('Store success.', $speaker);
    }

    /**
     * @param Speaker $speaker
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Speaker $speaker)
    {
        return $this->returnSuccess('Show success.', $speaker);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SpeakerRequest  $request
     * @param  Speaker  $speaker
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SpeakerRequest $request, Speaker $speaker)
    {
        $data = $request->except('file', 'last_edited_by');
        $data['last_edited_by'] = auth()->user()->name;
        $speaker->update($data);

        if ($request->hasFile('file')) {
            $speaker = $this->savePhoto($request->file('file'), $speaker);
        }

        return $this->returnSuccess('Update success.', $speaker);
    }

    /**
     * @param Speaker $speaker
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Speaker $speaker)
    {
        $speaker->delete();

        return $this->returnSuccess('destroy success.');
    }

    /**
     * @param $accessKey
     * @return \Illuminate\Http\JsonResponse
     */
    public function externalShow($accessKey)
    {
        $speaker = Speaker::where('access_key', '=', $accessKey)->first();
        return $this->returnSuccess('Success.', $speaker);
    }

    /**
     * @param  SpeakerRequest  $request
     * @param  $accessKey
     * @return \Illuminate\Http\JsonResponse
     */
    public function externalUpdate(SpeakerRequest $request, $accessKey)
    {
        $speaker = Speaker::where('access_key', '=', $accessKey)->first();
        if ($speaker) {
            $data = $request->except('file', 'speaker_status', 'speaker_type', 'last_edited_by');
            $data['last_edited_by'] = $speaker->name;
            $speaker->update($data);

            if ($request->hasFile('file')) {
                $speaker = $this->savePhoto($request->file('file'), $speaker);
            }
        }

        return $this->returnSuccess('Update success.', $speaker);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  UploadedFile  $image
     * @param  Speaker  $speaker
     * @return Speaker
     */
    public function savePhoto(UploadedFile $image, Speaker $speaker)
    {
        $newFileName = $speaker->name . '-' . Str::random(8) . '.' . $image->getClientOriginalExtension();
        $image->move(public_path(Speaker::$photoPath), $newFileName);

        $speaker->photo = Speaker::$photoPath . '/' . $newFileName;
        $speaker->save();

        return $speaker;
    }

    public function savePhotoTest(Request $request, $accessKey)
    {
        // print_r($request->file('file'));
        // die();
        $speaker = Speaker::where('access_key', '=', $accessKey)->first();
        if ($speaker) {
            $speaker = $this->savePhoto($request->file('file'), $speaker);
        }

        return $this->returnSuccess('Update success.', $speaker);
    }
}
