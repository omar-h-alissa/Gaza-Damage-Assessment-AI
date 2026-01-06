<?php

namespace App\Http\Livewire\User;

use App\Models\Report;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Spatie\Permission\Models\Role;

class ReportList extends Component
{
    public array|Collection $reports;

    protected $listeners = [
        'success' => 'updateReportList',
    ];


    public function render()
    {

        if (auth()->user()->hasRole(['admin', 'super_admin'])) {
            // المسؤول يشوف كل التقارير
            $this->reports = Report::orderBy('created_at', 'desc')->get();
        } else {
            // المستخدم يشوف تقاريره فقط
            $this->reports = Report::where('user_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->get();
        }


        return view('livewire.user.report-list');
    }

    public function mount()
    {
        $this->loadReports();
    }

    public function loadReports()
    {
        if (auth()->user()->hasRole(['admin', 'super_admin'])) {
            // المسؤول يشوف كل التقارير
            $this->reports = Report::orderBy('created_at', 'desc')->get();
        } else {
            // المستخدم يشوف تقاريره فقط
            $this->reports = Report::where('user_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->get();
        }
    }

    public function updateReportList()
    {
        if (auth()->user()->hasRole(['admin', 'super_admin'])) {
            // المسؤول يشوف كل التقارير
            $this->reports = Report::orderBy('created_at', 'desc')->get();
        } else {
            // المستخدم يشوف تقاريره فقط
            $this->reports = Report::where('user_id', auth()->id())
                ->orderBy('created_at', 'desc')
                ->get();
        }
    }

    public function deleteRepot($id)
    {
        $report = Report::where('id', $id)->where('user_id', Auth::id())->first();

        if (!$report) {
            $this->dispatch('error', __('messages.property_not_found'));
            return;
        }

        $report->delete();
        $this->dispatch('success', __('messages.property_deleted'));
        $this->loadReports();
    }


    public function hydrate()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }
}
