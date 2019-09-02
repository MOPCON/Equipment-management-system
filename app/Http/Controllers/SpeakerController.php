<?php

namespace App\Http\Controllers;

use App\Speaker;
use App\Http\Requests\SpeakerRequest;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;

class SpeakerController extends Controller
{
    use ApiTrait, CheckPermissionTrait;

    public static $hiddenFieldsForExternal = [
        'id',
        'speaker_status',
        'speaker_type',
        'speaker_status_text',
        'speaker_type_text',
        'is_keynote',
        'last_edited_by',
        'access_secret',
    ];

    public static $FieldsForTSV = [
        'id' => 'id',
        'name' => '姓名',
        'name_e' => '英文名稱',
        'company' => '公司/組織',
        'company_e' => '公司/組織(英文)',
        'job_title' => '職稱',
        'job_title_e' => '職稱(英文)',
        'bio' => '個人介紹',
        'bio_e' => '個人介紹(英文)',
        'photo' => '照片',
        'link_fb' => 'Facebook',
        'link_github' => 'Github',
        'link_twitter' => 'Twitter',
        'link_other' => '其他(如Website/Blog)',
        'topic' => '演講主題',
        'topic_e' => '演講主題(英文)',
        'summary' => '演講摘要',
        'summary_e' => '演講摘要(英文)',
        'tag_text' => '標籤',
        'level_text' => '難易度',
        'license_text' => '授權方式',
        'promotion' => '是否同意公開宣傳',
        'tshirt_size_text' => 'T-shirt 尺寸',
        'need_parking_space' => '您是否需有停車需求',
        'has_dinner' => '敬邀參加講者晚宴',
        'meal_preference_text' => '葷素食偏好',
        'has_companion' => '晚宴攜伴人數',
        'speaker_status_text' => '修改狀態',
        'speaker_type_text' => '修改類型',
        'is_keynote' => '是否為 keynote 講者',
        'note' => '備註',
        'external_link' => '表單連結',
        'access_secret' => 'Password',
        'updated_at' => '更新日期',
        'last_edited_by' => '最後更新者',
    ];

    public function __construct()
    {
        $this->checkPermissionApiResource();
    }

    /**
     * @param Request $request
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
                        ->orWhere('name_e', 'LIKE', '%' . $search . '%')
                        ->orWhere('company', 'LIKE', '%' . $search . '%')
                        ->orWhere('company_e', 'LIKE', '%' . $search . '%')
                        ->orWhere('topic', 'LIKE', '%' . $search . '%')
                        ->orWhere('topic_e', 'LIKE', '%' . $search . '%');
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
     * @param Collection $speakers
     * @return string
     */
    private function transformToTSV(Collection $speakers)
    {
        $fieldNames = implode("\t", array_values(SpeakerController::$FieldsForTSV)) . "\r\n";

        $output = $speakers->reduce(function ($carry, $item) {
            $row = '';

            foreach (array_keys(SpeakerController::$FieldsForTSV) as $key) {
                switch ($key) {
                    case 'tag_text':
                        $row .= implode(',', $item[$key]) . "\t";
                        break;
                    case 'promotion':
                    case 'need_parking_space':
                    case 'has_dinner':
                    case 'is_keynote':
                        $row .= (($item[$key] == 1)?'是':'否') . "\t";
                        break;
                    default:
                        $row .= "{$item[$key]}\t";
                }
            }

            $row .= "\r\n";

            return $carry .= $row;
        }, $fieldNames);

        return $output;
    }

    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\StreamedResponse
     */
    public function exportTSV(Request $request)
    {
        $filename = sprintf("speakers-%s.tsv", time());
        $headers = ['Content-Type' => 'text/tab-separated-values'];
        $ids = $request->query('ids', []);
        if (strpos($ids, ',') !== false) {
            $ids = explode(',', $ids);
        }
        if (empty($ids)) {
            return $this->return400Response();
        }

        $speakers = Speaker::WhereIn('id', $ids)->get();
        $callback = function () use ($speakers) {
            echo $this->transformToTSV($speakers);
        };

        return response()->streamDownload($callback, $filename, $headers);
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
     * @param string $accessKey
     * @return \Illuminate\Support\Facades\View
     */
    public function externalForm(string $accessKey)
    {
        $speaker = Speaker::where('access_key', '=', $accessKey)->first() ?? abort(404);

        if (! $speaker->editable) {
            return '目前表單已關閉';
        }

        $data = [
            'speaker' => $speaker->only(['access_key', 'readonly']),
        ];

        return view('form.speaker', $data);
    }

    /**
     * @param Request $request
     * @param string $accessKey
     * @return \Illuminate\Http\JsonResponse
     */
    public function externalShow(Request $request, string $accessKey)
    {
        if ($request->isMethod('get')) {
            return $this->return400Response();
        }

        $speaker = Speaker::where('access_key', '=', $accessKey)->firstOrFail();

        if (! $speaker->editable) {
            return $this->return400Response();
        }

        if ($speaker->access_secret !== $request->input('password')) {
            return $this->return400Response();
        }

        return $this->returnSuccess('Success.', $speaker->setHidden(SpeakerController::$hiddenFieldsForExternal));
    }

    /**
     * @param  SpeakerRequest  $request
     * @param  string $accessKey
     * @return \Illuminate\Http\JsonResponse
     */
    public function externalUpdate(SpeakerRequest $request, string $accessKey)
    {
        $speaker = Speaker::where('access_key', '=', $accessKey)->firstOrFail();
        if ($speaker) {
            if (! $speaker->editable || $speaker->readonly) {
                return $this->return400Response();
            }

            if ($speaker->access_secret !== $request->input('password')) {
                return $this->return400Response();
            }

            $data = $request->except(['file', 'speaker_status', 'speaker_type', 'last_edited_by', 'password']);
            $data['last_edited_by'] = $speaker->name;
            $data['speaker_status'] = 1;
            $speaker->update($data);

            if ($request->hasFile('file')) {
                $speaker = $this->savePhoto($request->file('file'), $speaker);
            }
        }

        return $this->returnSuccess('Update success.', $speaker->setHidden(SpeakerController::$hiddenFieldsForExternal));
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

        $speaker->photo = url(Speaker::$photoPath . '/' . $newFileName);
        $speaker->save();

        return $speaker;
    }
}
