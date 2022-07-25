<?php

namespace App\Nova\Dashboards;

use Laravel\Nova\Cards\Help;
use App\Nova\Metrics\ImportHistory;
use App\Nova\Metrics\SpektrixOverview;
use App\Nova\Metrics\ActivityOverview;

use Laravel\Nova\Dashboards\Main as Dashboard;

class Main extends Dashboard
{
    public function name()
    {
        return "Overview";
    }
    /**
     * Get the cards for the dashboard.
     *
     * @return array
     */
    public function cards()
    {
        return [
            new SpektrixOverview(),
            new ImportHistory(),
            (new ActivityOverview())->width("2/3")->fixedHeight(),
        ];
    }
}
