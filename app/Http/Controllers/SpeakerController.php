<?php

namespace App\Http\Controllers;

use App\Speaker;
use App\Http\Requests\SpeakerRequest;
use App\Http\Requests\ImportRequest;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use Illuminate\Support\Collection;
use App\Services\AutoCorrectService;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\Container\BindingResolutionException;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use InvalidArgumentException;

class SpeakerController extends Controller
{
    use ApiTrait, CheckPermissionTrait;

    public static $hiddenFieldsForExternal = [
        'id',
        'speaker_status',
        'speaker_type',
        'speaker_status_text',
        'speaker_type_text',
        'link_video',
        'is_keynote',
        'last_edited_by',
        'access_secret',
    ];

    public static $FieldsForTSV = [
        'id' => 'id',
        'name' => '姓名',
        'name_e' => '英文名稱',
        'real_name' => '真實姓名',
        'company' => '公司/組織',
        'company_e' => '公司/組織(英文)',
        'job_title' => '職稱',
        'job_title_e' => '職稱(英文)',
        'contact_email' => '聯絡 Email',
        'contact_phone' => '聯絡電話',
        'contact_address' => '聯絡地址',
        'bio' => '個人介紹',
        'bio_e' => '個人介紹(英文)',
        'photo' => '照片',
        'link_fb' => 'Facebook',
        'link_github' => 'Github',
        'link_twitter' => 'Twitter',
        'link_other' => '其他(如Website/Blog)',
        'link_slide' => '投影片連結',
        'link_video' => '錄影檔影片連結',
        'link_pre_video' => '預錄影片連結',
        'agree_act_change ' => '知悉活動會因狀況調整',
        'agree_record_qa'     => '我同意 Q&A 階段進行錄影',
        'agree_pre_video_public' => '我同意且知悉活動結束後七天內，預錄影片會放在 Youtube 供會眾觀看',
        'topic' => '演講主題',
        'topic_e' => '演講主題(英文)',
        'summary' => '演講摘要',
        'summary_e' => '演講摘要(英文)',
        'tag_text' => '標籤',
        'level_text' => '難易度',
        'target_audience' => '目標會眾',
        'target_audience_e' => '目標會眾(英文)',
        'prerequisites' => '先備知識',
        'prerequisites_e' => '先備知識(英文)',
        'expected_harvest' => '預期收穫',
        'expected_harvest_e' => '預期收穫(英文)',
        'agree_policy_text' => '授權方式 (1)',
        'license_text' => '授權方式 (2)',
        'promotion' => '是否願意被 MOPCON 的粉專提及或標註',
        'will_forward_posts' => '是否願意轉發 MOPCON 的講者宣傳文和大會其他文章',
        'tshirt_size_text' => 'T-shirt 尺寸',
        'need_parking_space' => '您是否需有停車需求',
        'year' => '年份',
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
        $filter = json_decode($request->input('filter', '{}'), true);
        $order_field = $request->input('orderby_field', 'id');
        $order_method = $request->input('orderby_method', 'desc');
        if ($request->input('all', false)) {
            $speaker = Speaker::orderBy($order_field, $order_method)->get();
        } else {
            $limit = $request->input('limit', 15);
            $speaker = Speaker::where(function ($query) use ($filter) {
                if (isset($filter['year'])) {
                    $query->where('year', $filter['year']);
                }

                if (isset($filter['status'])) {
                    $query->where('speaker_status', $filter['status']);
                }
            })
            ->where(function ($query) use ($search) {
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
        if (! $request->has('year')) {
            return $this->return400Response();
        }
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
                        $tags = array_map(function ($key) {
                            $transKey = 'speaker.tags.' . $key;
                            return trans($transKey, [], 'tw');
                        }, $item[$key]);
                        $row .= implode(',', $tags) . "\t";
                        break;
                    case 'promotion':
                    case 'need_parking_space':
                    case 'has_dinner':
                    case 'is_keynote':
                    case 'agree_record_qa':
                    case 'agree_act_change':
                    case 'agree_pre_video_public':
                        $row .= (($item[$key] == 1)?'是':'否') . "\t";
                        break;
                    default:
                        $item[$key] = str_replace(array("'",'"'), array('\x22','\x27'), $item[$key]);
                        $item[$key] = AutoCorrectService::autoSpace(str_replace(["\n", "\r\n", "\r", "&#8232;"], "\\n", $item[$key]));
                        $row .= "{$item[$key]}\t";
                }
            }

            $row .= "\r\n";

            return $carry .= $row;
        }, $fieldNames);

        return $output;
    }

    /**
     * for 2022
     * 匯入講者資料 CSV
     * csv example
     * 姓名,姓名(英文),公司/組織,公司/組織(英文),職稱,職稱(英文),個人介紹,個人介紹(英文),照片,Facebook Link,Github Link,Twitter,Link其他(如：Website / Blog),演講主題,演講主題(英文),演講摘要,演講摘要(英文),標籤,難易度,目標會眾,目標會眾(英文),先備知識,先備知識(英文),預期收穫,預期收穫(英文),授權方式,投影片連結,是否願意被 MOPCON 的粉專提及或標註？,是否願意轉發 MOPCON 的講者宣傳文和大會其他文章,真實姓名,聯絡 Email,聯絡電話,聯絡地址,T-shirt 尺寸,您是否需有停車需求,邀參加講者晚宴,葷素食偏好,晚宴攜伴人數,請填寫您可以進行演講的時段(可複選),備註
     *
     * @param ImportRequest $request
     * @return JsonResponse
     */
    public function importCSV(ImportRequest $request)
    {
        if (!$request->hasFile('upload')) {
            return $this->return400Response();
        }
        $file = $request->file('upload');
        if ($file->getClientOriginalExtension() !== 'csv') {
            return $this->return400Response('僅接受 csv 檔');
        };
        $handle = fopen($file->getRealPath(), "r");
        $content = [];
        $year = (int) date('Y');
        $count = 0;
        $now = now();
        while (($line = fgetcsv($handle, 1000, ',')) !== false) {
            foreach ($line as &$l) {
                $detect = mb_detect_encoding($l, ['UTF-8', "big5"]);
                if ($detect === 'UTF-8') {
                    continue;
                }
                try {
                    $l = mb_convert_encoding($l, 'UTF-8', $detect);
                } catch (\Exception $e) {
                    Log::error($line);
                    Log::error($detect);
                    Log::error($e->getMessage());

                    return $this->return400Response($e->getMessage());
                }
            }
            // 標題及空白列，忽略不處理
            if ($count <= 1) {
                $count++;
                continue;
            }
            
            // 參與者姓名為空，忽略不處理
            if (!isset($line[0]) || !is_string($line[0]) || trim($line[0]) === '') {
                continue;
            }
            $tagStr = '[]';
            if (isset($line[17]) && is_string($line[17]) && trim($line[17]) !== '') {
                $tags = array_map('trim', explode(' ', $line[17]));
                $chosenTag = array_intersect(Speaker::$tagItem, $tags);
                $tagStr = json_encode(array_keys($chosenTag));
            }
            $bio = $line[6] ?? null;
            $bio_e = $line[7] ?? null;
            $summary = $line[15] ?? null;
            $summary_e = $line[16] ?? null;
            $topic = $line[13] ?? null;
            $topic_e = $line[14] ?? null;
            $level = array_search($line[18], Speaker::$levelItem);
            $license = array_search($line[25], Speaker::$licenseItem);
            $promotion = ($line[27] == '是') ? 1 : 0;
            $will_forward_posts = ($line[28] == '是') ? 1 : 0;
            $tshirtSize = array_search($line[33], Speaker::$tshirtSizeItem);
            $need_parking_space = ($line[34] == '是') ? 1 : 0;
            $has_diner = ($line[35] == '是') ? 1 : 0;
            $meal_preference = ($line[36] != '葷') ? 1 : 0;
            $has_companion = $line[37] ?? 0;

            $content[] = [
                'speaker_status' => 0,
                'name'           => $line[0] ?? null,
                'name_e'         => $line[1] ?? null,
                'company'        => $line[2] ?? null,
                'company_e'      => $line[3] ?? null,
                'job_title'      => $line[4] ?? null,
                'job_title_e'    => $line[5] ?? null,
                'bio'            => $bio !== null ? $this->cutImportDataString($bio, 120) : null,
                'bio_e'          => $bio_e !== null ? $this->cutImportDataString($bio_e, 500) : null,   
                'link_fb'        => $line[9] ?? null,
                'link_github'    => $line[10] ?? null,
                'link_twitter'   => $line[11] ?? null,
                'link_other'     => $line[12] ?? null,
                'topic'          => $topic !== null ? $this->cutImportDataString($topic, 32) : null,
                'topic_e'        => $topic_e !== null ? $this->cutImportDataString($topic_e, 500) : null,
                'summary'        => $summary !== null ? $this->cutImportDataString($summary, 480) : null,
                'summary_e'      => $summary_e !== null ? $this->cutImportDataString($summary_e, 1000) : null,                
                'tag'            => $tagStr,
                'level'          => $level,
                'target_audience'=> $line[19] ?? null,
                'target_audience_e'=> $line[20] ?? null,
                'prerequisites'  => $line[21] ?? null,
                'prerequisites_e'=> $line[22] ?? null,
                'expected_harvest'=> $line[23] ?? null,
                'expected_harvest_e'=> $line[24] ?? null,
                'license'        => $license,                
                'link_slide'     => $line[26] ?? null,
                'promotion'      => $promotion,
                'will_forward_posts' => $will_forward_posts,
                'real_name'      => $line[29] ?? null,
                'contact_email'  => $line[30] ?? null,
                'contact_phone'  => $line[31] ?? null,
                'contact_address'=> $line[32] ?? null,
                'tshirt_size'    => $tshirtSize,
                'need_parking_space'=> $need_parking_space,
                'has_dinner'     => $has_diner,
                'meal_preference'=> $meal_preference,
                'has_companion'  => $has_companion,
                'note'           => $line[39] ?? null,
                'agree_record'   => 1,
                'year'           => $year,
                'speaker_type'   => 1,
                'last_edited_by' => auth()->user()->name,
                'access_key'     => Str::uuid(),
                'access_secret'  => Str::random(20),
                'updated_at'     => $now,
                'created_at'     => $now,
            ];
        }
        if (empty($content)) {
            return $this->return400Response('請檢查檔案內容');
        }

        DB::beginTransaction();
        try {
            $speaker = Speaker::insert($content);
            DB::commit();
            return $this->returnSuccess('Success.');
        } catch (\Exception $e) {
            DB::rollBack();
            return $this->return400Response('發生不明錯誤' . $line);
        }
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

        $speakers = Speaker::WhereIn('id', $ids)
            ->where('speaker_status', '!=', Speaker::NotEditableStatus)
            ->get();
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
        $tagItem = [];
        foreach (Speaker::$tagItem as $tagKey => $tag) {
            if (in_array($tag, Speaker::$hideTag)) {
                continue;
            }
            $transKey = 'speaker.tags.' . $tag;
            $tagItem[$tagKey] = trans($transKey);
        }
        $options = [
            'tagItem' => $tagItem,
            'levelItem' => Speaker::$levelItem,
            'licenseItem' => Speaker::$licenseItem,
            'agreePolicyItem' => Speaker::$agreePolicyItem,
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
            if (! $speaker->editable) {
                return $this->return400Response();
            }

            if ($speaker->access_secret !== $request->input('password')) {
                return $this->return400Response();
            }
            if ($speaker->readonly) {
                $data = $request->only(['link_slide', 'link_pre_video', 'last_edited_by', 'password']);
                $data['last_edited_by'] = $speaker->name;
            } else {
                $data = $request->except(['file', 'speaker_status', 'speaker_type', 'last_edited_by', 'password', 'year']);
                $data['last_edited_by'] = $speaker->name;
                $data['speaker_status'] = 1;
            }
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

    /**
     * 將過長字串刪減
     * @param string $string 原始字串
     * @param int    $length db 限制欄位長度
     * @return string
     */
    private function cutImportDataString(string $string, int $length)
    {
        return mb_substr(trim($string), 0, $length, 'utf-8');
    }
}
