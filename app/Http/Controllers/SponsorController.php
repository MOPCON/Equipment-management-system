<?php

namespace App\Http\Controllers;

use App\Sponsor;
use App\Http\Requests\SponsorRequest;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class SponsorController extends Controller
{
    use ApiTrait;

    public static $hiddenFieldsForExternal = [
        'id',
        'sponsor_status',
        'sponsor_type',
        'sponsor_status_text',
        'sponsor_type_text',
        'sponsor_file_text',
        'update_by',
        'access_secret'
    ];

    private static $uploadFileList = [
        'logo_path',
        'service_photo_path',
        'slide_path',
        'board_path',
        'advence_icck_ad_path',
        'advence_registration_ad_path',
        'advence_hall_flag_path',
        'advence_main_flow_flag_path',
    ];


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sponsor = Sponsor::all();
        return $this->returnSuccess('Success.', $sponsor);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->only(['name', 'sponsor_type']);
        $data['update_by'] = auth()->user()->id;
        $sponsor = Sponsor::create($data);

        return $this->returnSuccess('Success.', $sponsor);
    }

    /**
     * Display the specified resource.
     *
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $sponsor = Sponsor::findOrFail($id);
        $sponsorData = collect($sponsor);

        $data = [];
        foreach ($sponsorData as $key => $item) {
            if (preg_match('/(advence_)|(sponsor_type)|(sponsor_file_text)/', $key)) {
                $data['advence'][$key] = $item;
                continue;
            }

            if (preg_match('/(recipe_)/', $key)) {
                $data['recipe'][$key] = $item;
                continue;
            }

            if ($key === 'update_by') {
                $data['main'][$key] = $item ? $sponsor->user->name : $sponsor->name;
                continue;
            }

            $data['main'][$key] = $item;
        }

        return $this->returnSuccess('Show success.', $data);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  SponsorRequest  $request
     * @param  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SponsorRequest $request, $id)
    {
        $sponsor = Sponsor::findOrFail($id);
        $getFile = SponsorController::$uploadFileList;
        $except = array_merge($getFile, ['update_by']);
        $data = $request->except($except);
        $data['update_by'] = auth()->user()->id;

        //檔案上傳
        foreach ($getFile as $value) {
            if ($request->hasFile($value)) {
                $filename = $this->saveFile($request->file($value), $sponsor);
                $data[$value] = Sponsor::$filePath . '/' . $filename;
            }
        }

        $sponsor->update($data);

        return $this->returnSuccess('Update success.', $sponsor);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sponsor  $sponsor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sponsor $sponsor)
    {
        $sponsor->delete();

        return $this->returnSuccess('destroy success.');
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOptions()
    {
        $options = [
            'sponsorStatusItem' => Sponsor::$sponsorStatusItem,
            'sponsorTypeItem' => Sponsor::$sponsorTypeItem,
        ];

        return $this->returnSuccess('Success.', $options);
    }

    public function externalForm($accessKey)
    {
        $sponsor = Sponsor::where('access_key', '=', $accessKey)->firstOrFail();
        $data = [
            'main' => [
                'access_key' => $accessKey,
            ],
            'advence' => [],
            'recipe'  => [],
        ];

        return view('form.sponsor', $data);
    }

    public function externalShow(Request $request, $accessKey)
    {
        $sponsor = Sponsor::where('access_key', '=', $accessKey)->firstOrFail();

        $password = $request->input('password', '');
        if ($sponsor->access_secret !== $password) {
            return $this->return400Response('密碼錯誤');
        }
        $output = $sponsor->setHidden(SponsorController::$hiddenFieldsForExternal)->toArray();
        $data = [];
        foreach ($output as $key => $item) {
            if (preg_match('/(advence_)/', $key)) {
                $data['advence'][$key] = $item;
                continue;
            }

            if (preg_match('/(recipe_)/', $key)) {
                $data['recipe'][$key] = $item;
                continue;
            }

            $data['main'][$key] = $item;
        }
        return $this->returnSuccess('Success.', $data);
    }

    /**
     * @param  SponsorRequest  $request
     * @param  $accessKey
     * @return \Illuminate\Http\JsonResponse
     */
    public function externalUpdate(SponsorRequest $request, $accessKey)
    {
        $sponsor = Sponsor::where('access_key', '=', $accessKey)->firstOrFail();
        if ($sponsor) {
            if ($sponsor->access_secret !== $request->input('password')) {
                return $this->return400Response('密碼錯誤');
            }

            $getFile = SponsorController::$uploadFileList;
            $except = array_merge($getFile, ['Sponsor_status', 'Sponsor_type', 'update_by', 'password']);
            $data = $request->except($except);
            $data['update_by'] = 0;
            $data['sponsor_status'] = 1;

            //檔案上傳
            foreach ($getFile as $value) {
                if ($request->hasFile($value)) {
                    $filename = $this->saveFile($request->file($value), $sponsor);
                    $data[$value] = url(Sponsor::$filePath . '/' . $filename);
                }
            }

            $sponsor->update($data);

            $sponsorData = $sponsor->setHidden(SponsorController::$hiddenFieldsForExternal)->toArray();
            $data = [];
            foreach ($sponsorData as $key => $item) {
                if (preg_match('/(advence_)/', $key)) {
                    $data['advence'][$key] = $item;
                    continue;
                }

                if (preg_match('/(recipe_)/', $key)) {
                    $data['recipe'][$key] = $item;
                    continue;
                }

                $data['main'][$key] = $item;
            }
        }

        return $this->returnSuccess('Update success.', $data);
    }

    /**
     * 檔案上傳處理
     *
     * @param  UploadedFile  $file
     * @param  Sponsor  $sponsor
     * @return string file_path
     */
    public function saveFile(UploadedFile $file, Sponsor $sponsor)
    {
        $newFileName = $sponsor->name . '-' . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path(Sponsor::$filePath), $newFileName);

        return $newFileName;
    }
}
