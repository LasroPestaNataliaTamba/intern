<?php

namespace App\Filament\Resources\Repurchases\Pages;

use App\Filament\Resources\Repurchases\RepurchaseResource;
use Filament\Resources\Pages\EditRecord;
use Filament\Actions\Action;

class EditRepurchase extends EditRecord
{
    protected static string $resource = RepurchaseResource::class;

    public function mount($record): void
    {
        parent::mount($record);

        $user = auth()->user();
        $record = $this->record;

        // ❌ Finance & Director tidak boleh edit sama sekali
        if (in_array($user->role, ['finance', 'direktur'])) {
            abort(403);
        }

        // ❌ User hanya boleh edit miliknya & hanya jika pending
        abort_unless(
            $record->user_id === $user->id && $record->status === 'pending',
            403
        );
    }

    protected function mutateFormDataBeforeFill(array $data): array
    {
        // kalau finance / director → disable edit
        if (in_array(auth()->user()->role, ['finance', 'direktur'])) {
            $this->form->disabled(); // 🔥 bikin semua field readonly
        }

        return $data;
    }

    protected function getFormActions(): array
    {
        if (in_array(auth()->user()->role, ['finance', 'direktur'])) {
            return []; // ❌ tidak ada tombol save
        }

        return parent::getFormActions();
    }

    public static function getNavigationLabel(): string
    {
        return 'Edit Repurchase';
    }

    public function getHeaderActions(): array
    {
        return [

            Action::make('approve')
                ->label('Approve')
                ->color('success')
                ->visible(fn () =>
                    in_array(auth()->user()->role, ['finance', 'direktur'])
                    && $this->record->status === 'pending'
                )
                ->action(fn () =>
                    $this->record->update(['status' => 'approved'])
                ),

            Action::make('reject')
                ->label('Reject')
                ->color('danger')
                ->visible(fn () =>
                    in_array(auth()->user()->role, ['finance', 'direktur'])
                    && $this->record->status === 'pending'
                )
                ->action(fn () =>
                    $this->record->update(['status' => 'rejected'])
                ),

        ];
    }

}
