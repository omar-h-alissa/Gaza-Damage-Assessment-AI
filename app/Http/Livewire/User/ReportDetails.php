<?php

namespace App\Http\Livewire\User;

use App\Events\ReportStatusUpdated;
use App\Models\Activity;
use App\Models\Report;
use Livewire\Component;

class ReportDetails extends Component
{

    public $report;
    public $rejectReason = '';
    public $showRejectModal = false;

    public function render()
    {
        return view('livewire.user.report-details');
    }


    public function mount($id)
    {
        $this->report = Report::with('images', 'property')->findOrFail($id);
    }

    public function openRejectModal()
    {
        $this->showRejectModal = true;
    }

    public function approve()
    {
        $this->report->update(['status' => 'approved']);

        Activity::create([
            'user_id' => $this->report->user_id, // صاحب الطلب
            'title' => __('menu.request_approved', ['id' => $this->report->id]),
            'type' => 'success',          // اللون (success, danger, warning, info)
            'icon' => 'bi-check2-circle', // أيقونة مناسبة من Bootstrap Icons
        ]);


        event(new ReportStatusUpdated(
            $this->report,
            'approved',
            $this->report->user_id,
            null
        ));
        session()->flash('success', __('menu.report_approved'));
    }

    public function reject()
    {

        $this->validate([
            'rejectReason' => 'required|min:5'
        ]);

        $this->report->update([
            'status' => 'rejected',
            'reject_reason' => $this->rejectReason
        ]);

        $this->showRejectModal = false;


        Activity::create([
            'user_id' => $this->report->user_id, // صاحب الطلب
            'title' => __('menu.request_rejected', ['id' => $this->report->id]),
            'type' => 'danger',          // اللون (success, danger, warning, info)
            'icon' => 'bi-x-circle', // أيقونة مناسبة من Bootstrap Icons
        ]);

        event(new ReportStatusUpdated(
            $this->report,
            'rejected',
            $this->report->user_id,
            $this->rejectReason
        ));
        session()->flash('error', __('menu.report_rejected_flash'));
    }
}
