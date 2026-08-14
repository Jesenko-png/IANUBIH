<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CooperationInquiry;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;
use Throwable;

class CooperationInquiryController extends Controller
{
    public function index(): View
    {
        if (! Schema::hasTable('cooperation_inquiries')) {
            $inquiries = new LengthAwarePaginator([], 0, 20);
            $unreadCount = 0;
            $storageReady = false;

            return view('admin.cooperation-inquiries.index', compact(
                'inquiries',
                'unreadCount',
                'storageReady',
            ));
        }

        $inquiries = CooperationInquiry::query()
            ->with('viewer')
            ->latest()
            ->paginate(20);

        $unreadCount = CooperationInquiry::query()->unread()->count();
        $storageReady = true;

        return view('admin.cooperation-inquiries.index', compact(
            'inquiries',
            'unreadCount',
            'storageReady',
        ));
    }

    public function setup(): RedirectResponse
    {
        if (Schema::hasTable('cooperation_inquiries')) {
            return redirect()
                ->route('admin.cooperation-inquiries.index')
                ->with('status', __('cooperation.admin.storage_already_ready'));
        }

        try {
            if (Schema::hasTable('migrations')) {
                DB::table('migrations')
                    ->where('migration', '2026_08_14_000000_create_cooperation_inquiries_table')
                    ->delete();
            }

            $exitCode = Artisan::call('migrate', [
                '--force' => true,
                '--path' => 'database/migrations/2026_08_14_000000_create_cooperation_inquiries_table.php',
            ]);

            if ($exitCode !== 0 || ! Schema::hasTable('cooperation_inquiries')) {
                throw new \RuntimeException('The cooperation inquiries migration did not complete.');
            }

            if (DB::connection()->getDriverName() === 'sqlite') {
                DB::statement('PRAGMA optimize');
            }
        } catch (Throwable $exception) {
            report($exception);

            return redirect()
                ->route('admin.cooperation-inquiries.index')
                ->withErrors(['storage' => __('cooperation.admin.storage_error')]);
        }

        return redirect()
            ->route('admin.cooperation-inquiries.index')
            ->with('status', __('cooperation.admin.storage_ready'));
    }

    public function show(Request $request, CooperationInquiry $cooperationInquiry): View
    {
        if ($cooperationInquiry->isUnread()) {
            $cooperationInquiry->forceFill([
                'viewed_at' => now(),
                'viewed_by' => $request->user()->id,
            ])->save();
        }

        $cooperationInquiry->load('viewer');

        return view('admin.cooperation-inquiries.show', compact('cooperationInquiry'));
    }
}
