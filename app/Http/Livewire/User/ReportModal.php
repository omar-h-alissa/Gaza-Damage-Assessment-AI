<?php

namespace App\Http\Livewire\User;

use App\Models\Activity;
use App\Models\Property;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use App\Models\Report;
use Livewire\WithFileUploads;
use Illuminate\Support\Collection;
use Livewire\Attributes\On;
use OpenAI\Laravel\Facades\OpenAI;

class ReportModal extends Component
{
    use WithFileUploads;

    // تم إزالة $report و $report_id لأنهما يخصان التعديل
    public $property_id;
    public $damage_description;
    public $damage_type = 'partial';
    public $status = 'pending';

    public $damage_photos = [];

    public Collection $properties;

    protected $rules = [
        'property_id' => 'required|exists:properties,id',
        'damage_description' => 'required|string',
        // تم تعديل حجم الملف (فرض 3MB)
        'damage_type' => 'required|string',
        'damage_photos.*' => 'nullable|image', // 3MB = 3072 KB
    ];

    // تم إزالة listeners الخاص بالتعديل (modal.show.report)
    protected $listeners = [];

    public function mount()
    {
        $this->loadProperties();
        $this->dispatch('init-filepond');
    }

    // دالة جديدة لجلب العقارات (أعيدت صياغتها لتكون أكثر وضوحاً)
    public function loadProperties()
    {
        // جلب العقارات التي يمتلكها المستخدم والتي لم يتم الإبلاغ عنها بعد
        $reportedPropertyIds = Report::where('user_id', auth()->id())
            ->pluck('property_id')
            ->toArray();

        $this->properties = auth()->user()->properties()
            ->whereNotIn('id', $reportedPropertyIds)
            ->get();

        if ($this->properties === null) {
            $this->properties = collect([]);
        }
    }

    // تم إزالة دالة mountReport بالكامل لعدم وجود تعديل

    public function submit()
    {
        $this->validate();

        // إنشاء تقرير جديد فقط
        $report = new Report();


        $report->property_id = $this->property_id;
        $report->user_id = auth()->id();
        $report->damage_description = $this->damage_description;
        $report->damage_type = $this->damage_type;
        $report->status = 'pending';
        $report->save();

        // حفظ الصور
        if (!empty($this->damage_photos)) {
            foreach ($this->damage_photos as $photo) {
                $path = $photo->store('reports', 'public');

                $report->images()->create([
                    'path' => $path
                ]);
            }
        }

        Log::info('--- JOB STARTING ANALYSIS ---');
        \App\Jobs\AnalyzeReportDamage::dispatch((int)$report->id);        // ...
        $this->dispatch('success', __('menu.report_saved'));
        $this->dispatch('report.saved', $report->id);
        $this->dispatch('closeModal');
        $this->resetForm();

        $title = __('menu.report_submission', [
            'user' => auth()->user()->name,
            'property_id' => $report->property_id,
        ]);
        Activity::create([
            'user_id' => auth()->id(), // صاحب الطلب
            'title' => $title,
            'type' => 'info',          // اللون (success, danger, warning, info)
            'icon' => 'bi-clipboard-check', // أيقونة مناسبة من Bootstrap Icons
        ]);
    }

    #[On('reset-form')]
    public function resetForm()
    {
        // تم تبسيط Reset ليتوافق مع حقول الإضافة فقط
        $this->reset(['property_id', 'damage_description', 'damage_type', 'status', 'damage_photos']);
        $this->loadProperties(); // إعادة تحميل العقارات بعد التنظيف
        $this->dispatch('init-filepond'); // لإعادة تهيئة FilePond للتنظيف
    }


    public function render()
    {
        // تم إزالة تمرير report_id أو report
        return view('livewire.user.report-modal');
    }
}
