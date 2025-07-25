<?php

namespace App\Filament\Resources\DapurResource\Pages;

use App\Filament\Resources\DapurResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListDapurs extends ListRecords
{
    protected static string $resource = DapurResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
