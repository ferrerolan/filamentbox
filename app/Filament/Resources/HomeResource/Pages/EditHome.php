<?php

namespace App\Filament\Resources\HomeResource\Pages;

use App\Filament\Resources\HomeResource;
use Filament\Pages\Actions;
use Filament\Resources\Pages\EditRecord;

class EditHome extends EditRecord
{
    protected static string $resource = HomeResource::class;

    protected function getActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
