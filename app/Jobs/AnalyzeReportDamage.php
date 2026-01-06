<?php

namespace App\Jobs;

use App\Events\ReportAiFinished;
use App\Models\Activity;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Models\Report;
use OpenAI\Laravel\Facades\OpenAI;



class AnalyzeReportDamage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected int $reportId;


    public function __construct(int $reportId)
    {
        $this->reportId = $reportId;
    }


    public function handle(): void
    {

        $report = Report::with('images')->find($this->reportId);

        if (!$report) {
            Log::warning("Report ID {$this->reportId} not found for analysis job. Aborting.");
            return;
        }

        $analysis = $this->analyzeDamageFromReport($report);

        if ($analysis) {
            $report->update([
                'ai_analysis' => $analysis,
            ]);

            Activity::create([
                'user_id' => $report->user_id, // صاحب الطلب
                'title'   => __('menu.ai_analysis_completed', ['id' => $this->reportId]),
                'type' => 'success',          // اللون (success, danger, warning, info)
                'icon' => 'bi-check2-circle', // أيقونة مناسبة من Bootstrap Icons
            ]);

            if ( $this->reportId && $report->user_id) {
                event(new \App\Events\ReportAiFinished(
                    $report->user_id,
                    $this->reportId // 💡 الآن أنت متأكد بنسبة 99% أن الـ ID ليس null
                ));
            } else {
                // يمكنك تسجيل خطأ هنا إذا لم يكن الـ ID موجوداً
                \Log::error("Failed to broadcast ReportAiFinished: Report ID or User ID is missing for report with ID: {$report->id}");
            }


        } else {
            $report->update([
                'ai_analysis' => 'analysis_failed'
            ]);
        }
    }


    private function analyzeDamageFromReport(Report $report)
    {
        if ($report->images->isEmpty()) {
            Log::warning('Report has no images, skipping analysis.');
            return null;
        }

        $content = [
            [
                'type' => 'input_text',
                'text' => "حلل مستوى الضرر للبيت اعتماداً على جميع الصور التالية.
            المطلوب:
            - نسبة الضرر %
            - الحالة (جزئي – كلي – جزئي بليغ)
            - نسبة خطأ التقدير %

           أرجع الرد بصيغة JSON فقط هكذا:
            {
                \"percentage\": 00,
                \"state\": \"\",
                \"accuracy\": 00
            }"
            ]
        ];

        foreach ($report->images as $reportImage) {
            $filePath = $reportImage->path;
            $resizedTemp = null; // تهيئة متغير المسار المؤقت

            try {
                if (!Storage::disk('public')->exists($filePath)) {
                    Log::error("FILE NOT FOUND IN JOB: Path: {$filePath}. Skipping image.");
                    continue;
                }

                // 1. قراءة الملف المحفوظ من نظام التخزين
                $fileContents = Storage::disk('public')->get($filePath);

                // 2. معالجة وتصغير الصورة باستخدام مكتبة GD
                $image = imagecreatefromstring($fileContents);
                if ($image === false) {
                    throw new \Exception("Failed to create image resource from file contents.");
                }

                $small = imagescale($image, 800, 800);

                // حفظ الصورة المصغرة مؤقتاً
                $resizedTemp = storage_path('app/temp_' . uniqid() . '.jpg');
                imagejpeg($small, $resizedTemp, 60);

                // 3. تحويلها إلى Base64 للإرسال إلى OpenAI
                $base64 = base64_encode(file_get_contents($resizedTemp));

                $content[] = [
                    'type' => 'input_image',
                    'image_url' => "data:image/jpeg;base64,$base64"
                ];

            } catch (\Exception $e) {
                // تسجيل الخطأ وتخطي الصورة الحالية
                Log::error("Image Processing Failed for {$filePath}: " . $e->getMessage());
                continue;
            } finally {
                // 4. حذف الملف المؤقت بعد الانتهاء
                if ($resizedTemp && file_exists($resizedTemp)) {
                    unlink($resizedTemp);
                }
            }
        }

        // التحقق مرة أخرى: إذا لم يتمكن من إضافة أي صور، ننهي العملية
        if (count($content) === 1) {
            Log::error("No valid images were processed for Report ID: " . $report->id);
            return null;
        }

        try {
            // إرسال إلى OpenAI
            $response = OpenAI::responses()->create([
                'model' => 'gpt-5-nano',
                'input' => [
                    [
                        'role' => 'user',
                        'content' => $content
                    ]
                ]
            ]);

            $text = $response->outputText;
            $json = json_decode($text, true);

            return $json ? json_encode($json) : null;
        } catch (\Exception $e) {
            Log::error("OpenAI API Call Failed for Report ID {$report->id}: " . $e->getMessage());
            return null;
        }
    }
}
