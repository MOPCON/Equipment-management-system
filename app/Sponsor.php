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
    ];

    public static $sponsorHasItem = [
        self::TONYSTARK  => [0, 1, 2, 3, 4],
        self::BRUCEWAYNE => [2, 3, 4],
        self::HACKER     => [3, 4],
        self::DEVELOP    => [],
        self::OTHER      => [],
    ];
    
    public static $sponsorStatusItem = [
        '待確認',
        '確認中',
        '已確認',
        '下架',
    ];

    protected $fillable = [
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
        'updated_by'
    ];

    protected $appends = [
        'sponsor_type_text',
        'sponsor_file_text',
        'sponsor_status_text',
        'external_link',
    ];

    public static function boot()
    {
        parent::boot();

        self::creating(function ($model) {
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
}
