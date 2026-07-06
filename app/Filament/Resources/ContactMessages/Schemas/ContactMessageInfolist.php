<?php

namespace App\Filament\Resources\ContactMessages\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactMessageInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('admin.form.contact_infolist.section_detail'))
                    ->columns(2)
                    ->schema([
                        TextEntry::make('name')
                            ->label(__('admin.form.contact_infolist.name')),
                        TextEntry::make('company')
                            ->label(__('admin.form.contact_infolist.company')),
                        TextEntry::make('phone')
                            ->label(__('admin.form.contact_infolist.phone')),
                        TextEntry::make('email')
                            ->label(__('admin.form.contact_infolist.email')),
                        TextEntry::make('subject')
                            ->label(__('admin.form.contact_infolist.subject'))
                            ->columnSpanFull(),
                        TextEntry::make('message')
                            ->label(__('admin.form.contact_infolist.message'))
                            ->columnSpanFull()
                            ->markdown(),
                        TextEntry::make('created_at')
                            ->label(__('admin.form.contact_infolist.received'))
                            ->dateTime(),
                        TextEntry::make('read_at')
                            ->label(__('admin.form.contact_infolist.read'))
                            ->dateTime()
                            ->placeholder(__('admin.form.contact_infolist.not_read')),
                    ]),
            ]);
    }
}
