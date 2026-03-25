<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Activitylog\Models\Activity;

class AuditLogManager extends Component
{
    use WithPagination;

    public string $search = '';
    public string $filterEvent = '';
    public string $filterSubject = '';
    public bool $showDetail = false;
    public ?int $selectedId = null;

    public function updatingSearch(): void { $this->resetPage(); }
    public function updatingFilterEvent(): void { $this->resetPage(); }
    public function updatingFilterSubject(): void { $this->resetPage(); }

    public function openDetail(int $id): void
    {
        $this->selectedId = $id;
        $this->showDetail = true;
    }

    public function closeDetail(): void
    {
        $this->showDetail = false;
        $this->selectedId = null;
    }

    public function render()
    {
        $query = Activity::with('causer')
            ->latest();

        if ($this->search) {
            $query->where(function ($q) {
                $q->where('description', 'like', "%{$this->search}%")
                  ->orWhere('log_name', 'like', "%{$this->search}%")
                  ->orWhere('properties', 'like', "%{$this->search}%");
            });
        }

        if ($this->filterEvent) {
            $query->where('event', $this->filterEvent);
        }

        if ($this->filterSubject) {
            $query->where('subject_type', $this->filterSubject);
        }

        $detail = $this->selectedId ? Activity::with('causer', 'subject')->find($this->selectedId) : null;

        // Get distinct subject types for filter
        $subjectTypes = Activity::select('subject_type')
            ->distinct()
            ->whereNotNull('subject_type')
            ->pluck('subject_type')
            ->map(fn($t) => ['full' => $t, 'short' => class_basename($t)]);

        return view('livewire.admin.audit-log-manager', [
            'logs' => $query->paginate(20),
            'detail' => $detail,
            'subjectTypes' => $subjectTypes,
        ]);
    }
}
