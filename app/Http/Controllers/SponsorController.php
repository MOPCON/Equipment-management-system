<?php

namespace App\Http\Controllers;

use App\Sponsor;
use App\Http\Requests\SponsorRequest;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use App\Services\AutoCorrectService;

class SponsorController extends Controller
{
    use ApiTrait;
    use CheckPermissionTrait;

    private static $hiddenFieldsForExternal = [
        'id',
        'sponsor_status',
        'sponsor_status_text',
        'sponsor_type_text',
        'sponsor_file_text',
        'updated_by',
        'updated_by_name',
        'access_secret',
        'note',
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

    private static $cloudPaths = [
        'cloud_logo_path',
        'cloud_service_photo_path',
        'cloud_service_photo_path',
        'cloud_board_path',
        'cloud_advence_icck_ad_path',
        'cloud_advence_registration_ad_path',
        'cloud_advance_hall_flag_path',
        'cloud_advence_main_flow_flag_path',
    ];

    private static $FieldsForTSV = [
        'id'                            => 'id',
        'year'                          => '年份',
        'sponsor_status_text'           => '贊助商狀態',
        'sponsor_type_text'             => '贊助商類型',
        'name'                          => '公司名稱',
        'en_name'                       => '公司英文名稱',
        'introduction'                  => '公司簡介',
        'en_introduction'               => '公司英文簡介',
        'website'                       => '公司網站',
        'social_media'                  => '社群媒體(如FB等)',
        'production'                    => '產品及服務介紹',
        'logo_path'                     => 'logo',
        'service_photo_path'            => '產品或服務照片',
        'promote'                       => '希望MOPCON宣傳的內容',
        'slide_path'                    => '場間投影片',
        'board_path'                    => '電子看板',
        'opening_remarks'               => '晚宴簡介',
        'recipe_full_name'              => '公司/組織全銜',
        'recipe_tax_id_number'          => '統一編號',
        'recipe_amount'                 => '贊助金額',
        'recipe_contact_name'           => '聯絡人姓名',
        'recipe_contact_title'          => '聯絡人職稱',
        'recipe_contact_phone'          => '聯絡人電話',
        'recipe_contact_email'          => '聯絡人Email',
        'recipe_contact_address'        => '收件地址',
        'promotion_ad_media_link'       => '廣告播放連結',
        'promotion_warm_up_media_link'  => '暖場動畫連結',
        'promotion_discord_intro'       => 'Discord 攤位宣傳簡介',
        'promotion_email_short'         => '公司或活動簡短介紹文',
        'promotion_email_url'           => '可為官網或宣傳內容相關連結',
        'advence_icck_ad_path'          => 'ICCK大門兩側廣告',
        'advence_registration_ad_path'  => '報到處全版廣告空間',
        'advence_keynote'               => 'Keynote 引言',
        'advence_hall_flag_path'        => '演講廳旗幟',
        'advence_main_flow_flag_path'   => '主動線旗幟廣告',
        'reason'                        => '為什麼本次選擇贊助 MOPCON？',
        'purpose'                       => '希望能在本次大會達成的目標',
        'remark'                        => '備註',
        'external_link'                 => '外部連結',
        'access_secret'                 => '密碼',
        'note'                          => '後台備註',
        'updated_at'                    => '更新日期',
        'updated_by'                    => '最後更新者',
    ];

    public function __construct()
    {
        $this->checkPermissionApiResource();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $search = $request->input('search', '');
        $filter = json_decode($request->input('filter', '{}'), true); //year, status, type
        $order_field = $request->input('sort', 'id');
        $order_method = $request->input('order', 'desc');
        $limit = $request->input('limit', 25);

        $sponsor = Sponsor::where(function ($query) use ($filter) {
            if (isset($filter['year'])) {
                $query->where('year', $filter['year']);
            }
            
            if (isset($filter['status'])) {
                $query->where('sponsor_status', $filter['status']);
            }

            if (isset($filter['type'])) {
                $query->where('sponsor_type', $filter['type']);
            }
        })
            ->where(function ($query) use ($search) {
                if ($search !== '') {
                    $query->orWhere('name', 'LIKE', '%' . $search . '%')
                        ->orWhere('recipe_contact_name', 'LIKE', '%' . $search . '%');
                }
            })
            ->orderBy($order_field, $order_method)
            ->paginate($limit);

        return $this->returnSuccess('Success.', $sponsor);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SponsorRequest $request)
    {
        if (!$request->has('recipe_amount') || is_null($request->input('recipe_amount'))) {
            return $this->return400Response('請填寫贊助金額');
        }
        $data = $request->only(['name', 'sponsor_type', 'recipe_amount']);
        $data['updated_by'] = auth()->user()->id;
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
        $data = $this->arrangeSponsorData($sponsor);

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
        if (!$request->has('year')) {
            return $this->return400Response();
        }

        $sponsor = Sponsor::findOrFail($id);
        $getFile = SponsorController::$uploadFileList;
        $cloudPaths = SponsorController::$cloudPaths;
        $except = array_merge($getFile, $cloudPaths);
        $data = $request->except($except);
        $data['updated_by'] = auth()->user()->id;

        //檔案上傳
        foreach ($getFile as $value) {
            $check = $this->fileCheck($value, $request);
            if (!$check) {
                $trans = preg_replace('/advence_|_ad|_path/', '', $value);
                $middle = preg_match('/advence_/', $value) ? 'advance' : 'main';
                $msg = __('sponsor.' . $middle . '.' . $trans) . ' ' . __('sponsor.cloud.error');
                return $this->return400Response($msg);
            }
            $path = $this->fileProcess($value, $request, $sponsor);
            if ($path === '') {
                continue;
            }
            $data[$value] = $path;
        }

        $sponsor->update($data);

        $sponsorData = $this->arrangeSponsorData($sponsor);

        return $this->returnSuccess('Update success.', $sponsorData);
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

    public function exportTSV(Request $request)
    {
        $ids = $request->query('ids', '');
        if (is_null($ids) || $ids === '') {
            return $this->return400Response('沒有選擇贊助商');
        }
        $find_ids = explode(',', $ids);
        $sponsors = Sponsor::WhereIn('id', $find_ids)
            ->where('sponsor_status', '!=', Sponsor::NotEditableStatus)
            ->get()->toArray();
        $callback = function () use ($sponsors) {
            echo $this->transformToTSV($sponsors);
        };

        $filename = sprintf("sponsors-%s.tsv", time());
        $headers = ['Content-Type' => 'text/tab-separated-values'];

        return response()->streamDownload($callback, $filename, $headers);
    }

    private function transformToTSV(array $sponsors)
    {
        $output_rows = [];
        $field_names_row = implode("\t", SponsorController::$FieldsForTSV);
        $output_rows[] = $field_names_row;

        $fieldNameKeys = array_keys(SponsorController::$FieldsForTSV);

        foreach ($sponsors as $sponsor) {
            $row = [];
            foreach ($fieldNameKeys as $key) {
                $sponsor[$key] = str_replace(array("'",'"'), array('\x22','\x27'), $sponsor[$key]);
                $row[] = AutoCorrectService::autoSpace(str_replace(["\n", "\r\n", "\r", "&#8232;"], "\\n", $sponsor[$key]));
            }
            $output_rows[] = implode("\t", $row);
        }
        $output = implode("\n", $output_rows);
        return $output;
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

        if (! $sponsor->editable) {
            return '目前表單已關閉';
        }

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

        if (! $sponsor->editable) {
            return $this->return400Response();
        }

        $password = $request->input('password', '');
        if ($sponsor->access_secret !== $password) {
            return $this->return400Response('密碼錯誤');
        }

        $data = $sponsor->setHidden(SponsorController::$hiddenFieldsForExternal);
        $result = $this->arrangeSponsorData($data);

        return $this->returnSuccess('Success.', $result);
    }

    /**
     * @param  SponsorRequest  $request
     * @param  $accessKey
     * @return \Illuminate\Http\JsonResponse
     */
    public function externalUpdate(SponsorRequest $request, $accessKey)
    {
        $sponsor = Sponsor::where('access_key', '=', $accessKey)->firstOrFail();

        if (! $sponsor->editable) {
            return $this->return400Response();
        }

        if ($sponsor->access_secret !== $request->input('password')) {
            return $this->return400Response('密碼錯誤');
        }

        $getFile = SponsorController::$uploadFileList;
        $cloudPaths = SponsorController::$cloudPaths;
        $except = array_merge($getFile, $cloudPaths, ['year', 'sponsor_status', 'sponsor_type', 'updated_by', 'password', 'recipe_amount']);
        $data = $request->except($except);
        $data['updated_by'] = 0;
        $data['sponsor_status'] = 1;

        //檔案上傳
        foreach ($getFile as $value) {
            $check = $this->fileCheck($value, $request);
            if (!$check) {
                $trans = preg_replace('/(advence_)|(_ad)|(_path)/', '', $value);
                $middle = preg_match('/(advence_)/', $value) ? 'advance' : 'main';
                $msg = __('sponsor.' . $middle . '.' . $trans) . ' ' . __('sponsor.cloud.error');
                return $this->return400Response($msg);
            }
            $path = $this->fileProcess($value, $request, $sponsor);
            if ($path === '') {
                continue;
            }
            $data[$value] = $path;
        }

        $sponsor->update($data);

        $sponsorData = $sponsor->setHidden(SponsorController::$hiddenFieldsForExternal);
        $result = $this->arrangeSponsorData($sponsorData);

        return $this->returnSuccess('Update success.', $result);
    }

    /**
     * 檔案上傳處理
     *
     * @param  UploadedFile  $file
     * @param  Sponsor  $sponsor
     * @return string file_path
     */
    private function saveFile(UploadedFile $file, Sponsor $sponsor)
    {
        $newFileName = $sponsor->name . '-' . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $file->move(public_path(Sponsor::$filePath), $newFileName);

        return $newFileName;
    }

    private function fileCheck($field, SponsorRequest $request)
    {
        $cloudpath = $request->input('cloud_' . $field, '');
        if ($request->hasFile($field) && $cloudpath !== '') {
            return false;
        }
        return true;
    }

    private function fileProcess($field, SponsorRequest $request, Sponsor $sponsor)
    {
        if ($request->hasFile($field)) {
            $filename = $this->saveFile($request->file($field), $sponsor);
            return url(Sponsor::$filePath . '/' . $filename);
        }

        $cloudpath = $request->input('cloud_' . $field, '');
        return $cloudpath;
    }

    /**
     * 整理 sponsor 資料為 main, recipe, advance
     *
     * @param  Sponsor $sponsor
     * @return Array
     */
    private function arrangeSponsorData(Sponsor $sponsor)
    {
        $data = [];
        $preg_path = url(Sponsor::$filePath);
        $preg_path = preg_replace('/\//', '\/', $preg_path);
        // dd($sponsor->toArray());
        foreach ($sponsor->toArray() as $key => $item) {
            if (preg_match('/(advence_)|(sponsor_type)|(sponsor_file_text)|(promotion_)/', $key)) {
                if (!preg_match('/(_path)/', $key)) {
                    $data['advence'][$key] = $item;
                    continue;
                }
                if (!preg_match("/($preg_path)/", $item)) {
                    $data['advence']['cloud_' . $key] = $item;
                    $data['advence'][$key] = null;
                    continue;
                }
                $data['advence'][$key] = $item;
                $data['advence']['cloud_' . $key] = null;
                continue;
            }

            if (preg_match('/(recipe_)/', $key)) {
                $data['recipe'][$key] = $item;
                continue;
            }

            if ($key === 'updated_by') {
                $data['main'][$key] = $item ? $sponsor->user->name : $sponsor->name;
                continue;
            }
            if (!preg_match('/(_path)/', $key)) {
                $data['main'][$key] = $item;
                continue;
            }
            if (!preg_match("/($preg_path)/", $item)) {
                $data['main']['cloud_' . $key] = $item;
                $data['main'][$key] = null;
                continue;
            }

            $data['main'][$key] = $item;
            $data['main']['cloud_' . $key] = null;
            continue;
        }

        return $data;
    }
}
