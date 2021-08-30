<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Sponsor extends Model
{
    protected $table = 'sponsors';

    public static $filePath = '/images/sponsor';

    private const TONYSTARK = 'Tony Stark';
    private const BRUCEWAYNE = 'Bruce Wayne';
    private const HACKER = 'Hacker';
    private const DEVELOP = 'Developer';
    private const OTHER = '其他';

    public const ReadyToConfirmStatus = 0;
    public const OnCheckStatus = 1;
    public const ConfirmedStatus = 2;
    public const NotEditableStatus = 3; // based on $sponsorStatusItem

    public static $sponsorTypeItem = [
        self::TONYSTARK,
        self::BRUCEWAYNE,
        self::HACKER,
        self::DEVELOP,
        self::OTHER,
    ];

    public static $sponsorFileItem = [
        'ICCK 大門兩側廣告',
        '報到處全版廣告空間',
        'Keynote 引言',
        '演講廳旗幟',
        '主動線旗幟廣告',
        '廣告播放',
        'Email 行前通知信宣傳',
        'Discord 攤位宣傳簡介',
        '暖場動畫',
        'Gather Town 橫式圖片',
        'Gather Town 直式圖片',
        'Gather Town 宣傳影片',
    ];

    public static $promotionTimeLimit = [
        self::TONYSTARK => '60',
        self::BRUCEWAYNE => '30',
        self::HACKER => '15',
        self::DEVELOP => '5',
        self::OTHER => '0',
    ];

    public static $sponsorHasItem = [
        self::TONYSTARK  => [2,5,6,7,8,9,10,11],
        self::BRUCEWAYNE => [5,6,7,9,10,11],
        self::HACKER     => [5,6],
        self::DEVELOP    => [5],
        self::OTHER      => [],
    ];

    public static $sponsorStatusItem = [
        self::ReadyToConfirmStatus => '待確認',
        self::OnCheckStatus => '確認中',
        self::ConfirmedStatus => '已確認',
        self::NotEditableStatus => '下架',
    ];

    protected $fillable = [
        'year',
        'sponsor_type',
        'sponsor_status',
        'name',
        'en_name',
        'introduction',
        'en_introduction',
        'website',
        'social_media',
        'production',
        'logo_path',
        'service_photo_path',
        'promote',
        'slide_path',
        'board_path',
        'opening_remarks',
        'recipe_full_name',
        'recipe_tax_id_number',
        'recipe_amount',
        'recipe_contact_name',
        'recipe_contact_title',
        'recipe_contact_phone',
        'recipe_contact_email',
        'recipe_contact_address',
        'reason',
        'purpose',
        'remark',
        'advence_icck_ad_path',
        'advence_registration_ad_path',
        'advence_keynote',
        'advence_hall_flag_path',
        'advence_main_flow_flag_path',
        'promotion_ad_media_link',
        'promotion_warm_up_media_link',
        'promotion_discord_intro',
        'promotion_email_short',
        'promotion_email_url',
        'promotion_email_image',
        'promotion_gather_town_h_link',
        'promotion_gather_town_v_link',
        'promotion_gather_town_video_link',
        'updated_by',
    ];

    protected $appends = [
        'sponsor_type_text',
        'sponsor_file_text',
        'sponsor_status_text',
        'external_link',
        'editable',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
            $model->year           = now()->year;
            $model->sponsor_status = 0;
            $model->access_key     = Str::uuid();
            $model->access_secret  = Str::random(20);
        });
    }

    public function getSponsorTypeTextAttribute()
    {
        return self::$sponsorTypeItem[$this->sponsor_type] ?? '';
    }

    public function getSponsorFileTextAttribute()
    {
        $sponsorFileKey = self::$sponsorTypeItem[$this->sponsor_type];
        $sponsorFileFieldKeys = collect(self::$sponsorHasItem[$sponsorFileKey]);

        if (empty($sponsorFileFieldKeys)) {
            $sponsorFields = collect([]);
        } else {
            $sponsorFields = $sponsorFileFieldKeys->map(function ($item) {
                return self::$sponsorFileItem[$item];
            });
        }

        return $sponsorFields->all();
    }

    public function getSponsorStatusTextAttribute()
    {
        return self::$sponsorStatusItem[$this->sponsor_status] ?? '';
    }

    public function getExternalLinkAttribute()
    {
        return $this->access_key ? (url("/sponsor/form/{$this->access_key}")) : '';
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'updated_by');
    }

    public function getEditableAttribute()
    {
        return $this->sponsor_status !== self::NotEditableStatus;
    }
}
