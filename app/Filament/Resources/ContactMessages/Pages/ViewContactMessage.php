<?php

namespace App\Filament\Resources\ContactMessages\Pages;

use App\Filament\Resources\ContactMessages\ContactMessageResource;
use App\Filament\Resources\ContactMessages\Schemas\ContactMessageInfolist;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;

class ViewContactMessage extends ViewRecord
{
    protected static string $resource = ContactMessageResource::class;

    public function infolist(Schema $schema): Schema
    {
        return ContactMessageInfolist::configure($schema);
    }

    protected function afterMount(): void
    {
        if ($this->record->read_at === null) {
            $this->record->update(['read_at' => now()]);
        }
    }
}
