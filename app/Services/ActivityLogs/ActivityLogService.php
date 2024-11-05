<?php

namespace App\Services\ActivityLog;

use App\Models\ActivityLog;

class ActivityLogService
{
    public function __construct()
    {
    }

    /**
     * Get All Activity Log List
     *
     * @return mixed
     */
    public function getActivityLogList()
    {
        return ActivityLog::all();
    }
}
