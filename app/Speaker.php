<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Speaker extends Model
{
    public static $tagItem = [
        'AI',
        'AR/VR',
        'Blockchain',
        'Cloud',
        'DevOps',
        'IoT',
        'Mobile App',
        'Startup',
        'UI/UX',
        'Web',
        'Quant',
        'Security',
        'Cross-platform',
        'Data Science',
    ];
    public static $levelItem = [
        'Basic-外行人可以藉此入門',
        'Normal-歡迎略懂略懂有基本基礎的會眾',
        'Expert-建議在該領域中有研究經驗的人入場',
    ];
    public static $licenseItem = [
        '授予 MOPCON 演講時錄影，後製與上傳至公開線上影音平台之權利。',
        '以 CC BY 3.0 姓名標示方式授權。',
        '以 CC BY-SA 3.0 姓名標示-相同方式授權。',
        '以 CC BY-NC 3.0 姓名標示-非商業性方式授權。',
        '謝絕所有錄音錄影，但接受 MOPCON 工作人員文字紀錄。',
    ];
    public static $tshirtSizeItem = [
        'XS',
        'S',
        'M',
        'L',
        'XL',
    ];
    public static $mealPreferenceItem = [
        '葷',
        '全素',
        '奶蛋素',
    ];
    protected $table = 'speakers';
    protected $fillable = [
        'name',
        'name_e',
        'company',
        'job_title',
        'bio',
        'bio_e',
        'photo',
        'link_fb',
        'link_github',
        'link_twitter',
        'link_other',
        'topic',
        'topic_e',
        'summary',
        'summary_e',
        'tag',
        'level',
        'license',
        'promotion',
        'tshirt_size',
        'need_parking_space',
        'has_dinner',
        'meal_preference',
        'has_companion',
        'access_secret',
    ];
    protected $appends = [
        'tag_text',
        'level_text',
        'license_text',
        'tshirt_size_text',
        'meal_preference_text'
    ];
    protected $casts = ['tag' => 'array'];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->access_key = Str::uuid();
            $model->access_secret = Str::random(20);
        });
    }

    public function getTaxTextAttribute()
    {
        $tmp_collection = collect($this->tag);
        $new_collection = $tmp_collection->map(function ($item) {
            return $this->tagItem[$item];
        });

        return $new_collection->all();
    }

    public function getLevelTextAttribute()
    {
        return $this->levelItem[$this->level];
    }

    public function getLicenseTextAttribute()
    {
        return $this->licenseItem[$this->license];
    }

    public function getTshirtTextAttribute()
    {
        return $this->tshirtSizeItem[$this->tshirt_size];
    }

    public function getMealPreferenceTextAttribute()
    {
        return $this->mealPreferenceItem[$this->meal_preference];
    }
}
