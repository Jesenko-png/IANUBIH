<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\Ga4Analytics;
use Illuminate\View\View;
use Throwable;

class AnalyticsController extends Controller
{
    public function index(Ga4Analytics $analytics): View
    {
        $setupIssue = $analytics->setupIssue();
        $dashboard = null;
        $loadError = false;

        if ($setupIssue === null) {
            try {
                $dashboard = $analytics->dashboard();
            } catch (Throwable $exception) {
                report($exception);
                $loadError = true;
            }
        }

        return view('admin.analytics.index', compact('dashboard', 'setupIssue', 'loadError'));
    }
}
