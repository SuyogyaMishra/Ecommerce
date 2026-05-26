<?php

namespace App\Core\Libraries;

use App\Core\Models\ActivityModel;

class Logger
{
    private static $instance = null;
    private $activityModel;

    private function __construct()
    {
        $this->activityModel = new ActivityModel();
    }

    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function logActivity($action, $metaData = null)
    {
        return $this->activityModel->logActivity( $action, $metaData);
    }
}