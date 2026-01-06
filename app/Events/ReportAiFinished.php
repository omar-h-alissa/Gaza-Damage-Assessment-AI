<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReportAiFinished implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $userId;
    public $reportId;

    public function __construct(int $userId, int $reportId)
    {
        $this->userId   = $userId;
        $this->reportId = $reportId;
    }

    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('reports.' . $this->userId)
        ];
    }

    public function broadcastAs(): string
    {
        return 'report.ai.finished';
    }
}
