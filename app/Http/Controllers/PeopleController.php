<?php

namespace App\Http\Controllers;

use App\Models\AcademyMember;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\View\View;

class PeopleController extends Controller
{
    public function index(Request $request): View
    {
        $search = $request->query('q');
        $search = is_string($search) ? mb_substr(trim($search), 0, 100) : '';
        $storageReady = Schema::hasTable('academy_members');

        if (! $storageReady) {
            $members = new LengthAwarePaginator([], 0, 12);
        } else {
            $members = AcademyMember::query()
                ->published()
                ->when($search !== '', function ($query) use ($search) {
                    $query->where(function ($query) use ($search) {
                        foreach ([
                            'name', 'academic_title', 'category_bs', 'category_en',
                            'position_bs', 'position_en', 'field_bs', 'field_en',
                            'institution_bs', 'institution_en', 'country_bs', 'country_en',
                        ] as $column) {
                            $query->orWhere($column, 'like', '%'.$search.'%');
                        }
                    });
                })
                ->orderBy('sort_order')
                ->orderBy('name')
                ->paginate(12)
                ->withQueryString();
        }

        return view('pages.people.index', compact('members', 'search', 'storageReady'));
    }

    public function show(string $locale, string $slug): View
    {
        abort_unless(Schema::hasTable('academy_members'), 404);

        $member = AcademyMember::query()
            ->published()
            ->where('slug', $slug)
            ->firstOrFail();

        return view('pages.people.show', compact('member'));
    }
}
