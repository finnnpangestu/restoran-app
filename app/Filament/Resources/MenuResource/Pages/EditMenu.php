<?php

namespace App\Filament\Resources\MenuResource\Pages;

use App\Filament\Resources\MenuResource;
use App\Models\User;
use Filament\Actions;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;

class EditMenu extends EditRecord
{
    protected static string $resource = MenuResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordCreation(array $data): Model
    {
        $recipient = User::where('email', 'user@gmail.com')->first();

        $menu = static::getModel()::create($data);

        if ($recipient) {
            // Kirim notifikasi ke user yang ditemukan
            Notification::make()
                ->title('Menu berhasil diubah')
                ->success()
                ->body(`Menu $menu->nama_menu berhasi diubah.`)
                ->actions([
                    Action::make('Lihat Menu')
                        ->url(route('filament.admin.resources.menus.edit', ['record' => $menu->id]))
                ])
                ->sendToDatabase($recipient);
        }

        return $menu;
    }
}
