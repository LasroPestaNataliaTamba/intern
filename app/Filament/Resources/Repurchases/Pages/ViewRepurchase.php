<?php

namespace App\Filament\Resources\Repurchases\Pages;

use App\Filament\Resources\Repurchases\RepurchaseResource;
use Filament\Resources\Pages\ViewRecord;
use Filament\Actions\Action;

class ViewRepurchase extends ViewRecord
{
    protected static string $resource = RepurchaseResource::class;

    protected function getHeaderActions(): array
    {
        return [

            Action::make('approve')
                ->label('Approve')
                ->color('success')
                ->visible(function () {

                    $user = auth()->user();
                    $status = $this->record->status;

                    // 🔥 FINANCE
                    if ($user->hasRole('finance') && $status === 'pending') {
                        return true;
                    }

                    // 🔥 DIREKTUR
                    if ($user->hasRole('direktur') && $status === 'approved_finance') {
                        return true;
                    }

                    return false;
                })
                ->action(function () {

                    $user = auth()->user();

                    // FINANCE APPROVE
                    if ($user->hasRole('finance') && $this->record->status === 'pending') {
                        $this->record->update([
                            'status' => 'approved_finance'
                        ]);
                    }

                    // DIREKTUR APPROVE
                    elseif ($user->hasRole('direktur') && $this->record->status === 'approved_finance') {
                        $this->record->update([
                            'status' => 'approved'
                        ]);
                    }

                }),

            Action::make('reject')
                ->label('Reject')
                ->color('danger')
                ->visible(fn () =>
                    auth()->user()?->hasAnyRole(['finance', 'direktur'])
                    && $this->record->status !== 'approved'
                )
                ->action(function () {
                    $this->record->update([
                        'status' => 'rejected'
                    ]);
                }),
        ];
    }

    public function mount($record): void
    {
        parent::mount($record);

        $user = auth()->user();
        $record = $this->record;

        if (!$user->hasAnyRole(['finance', 'direktur'])) {
            abort_unless($record->user_id === $user->id, 403);
        }
    }
}
