<?php

namespace App\Http\Controllers;

use App\Speaker;
use Illuminate\Http\Request;
use App\Http\Requests\SpeakerRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class SpeakerController extends Controller
{
    use ApiTrait;
    // use CheckPermissionTrait;

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
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $speaker = Speaker::findOrFail($id);
        return $this->returnSuccess('Show success.', $speaker);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  SpeakerRequest  $request
     * @param             $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(SpeakerRequest $request, $id)
    {
        $speaker = Speaker::findOrFail($id);
        $data = $request->except(['file', 'last_edited_by']);
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOptions()
    {
        $options = [
            'tagItem' => Speaker::$tagItem,
            'levelItem' => Speaker::$levelItem,
            'licenseItem' => Speaker::$licenseItem,
            'tshirtSizeItem' => Speaker::$tshirtSizeItem,
            'mealPreferenceItem' => Speaker::$mealPreferenceItem,
            'speakerStatusItem' => Speaker::$speakerStatusItem,
            'speakerTypeItem' => Speaker::$speakerTypeItem,
        ];

        return $this->returnSuccess('Success.', $options);
    }

    /**
     * @param $accessKey
     * @return \Illuminate\Http\JsonResponse
     */
    public function externalShow($accessKey)
    {
        $speaker = Speaker::where('access_key', '=', $accessKey)->first()->setHidden(['id', 'speaker_status', 'speaker_type', 'speaker_status_text', 'speaker_type_text', 'last_edited_by', 'access_secret']);
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
            if ($speaker->access_secret !== $request->input('password')) {
                return $this->return400Response();
            }

            $data = $request->except(['file', 'speaker_status', 'speaker_type', 'last_edited_by', 'password']);
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
}
