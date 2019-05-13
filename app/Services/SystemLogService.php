<?php

namespace App\Services;

use App\SystemLog;
use App\SystemLogType;
use Jenssegers\Agent\Agent;

class SystemLogService
{

    /**
     * 寫入 system log
     * @param string $content 要寫入的訊息內容
     * @param int $type_id  類別 id
     */
    public function write($content, $type_id)
    {
        if (empty($content)) {
            return;
        }

        $type = SystemLogType::findOrFail($type_id);
        $agent = new Agent();

        $device = $agent->device();
        if ($agent->isDesktop()) {
            $device = 'desktop';
        }

        SystemLog::create([
            'user_id' => auth()->id(),
            'type_id' => $type->id,
            'content' => $content,
            'ip' => \Request::ip(),
            'device' => $device,
            'browser' => $agent->browser(),
        ]);
    }
}
