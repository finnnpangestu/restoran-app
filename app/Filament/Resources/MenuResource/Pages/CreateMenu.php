<?php

namespace App\Filament\Resources\MenuResource\Pages;

use App\Filament\Resources\MenuResource;
use App\Models\User;
use Filament\Notifications\Notification;
use Filament\Notifications\Actions\Action;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class CreateMenu extends CreateRecord
{
    protected static string $resource = MenuResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $recipient = User::where('email', 'user@gmail.com')->first();

        $menu = static::getModel()::create($data);

        if ($recipient) {
            // Kirim notifikasi ke user yang ditemukan
            Notification::make()
                ->title('Menu berhasil dibuat')
                ->success()
                ->body('Menu baru telah ditambahkan.')
                ->actions([
                    Action::make('Lihat Menu')
                        ->url(route('filament.admin.resources.menus.edit', ['record' => $menu->id]))
                ])
                ->sendToDatabase($recipient);
        }

        return $menu;
    }
}
