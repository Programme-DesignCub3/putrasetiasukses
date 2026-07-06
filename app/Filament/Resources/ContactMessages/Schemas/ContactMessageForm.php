<?php

namespace App\Filament\Resources\ContactMessages\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ContactMessageForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('admin.form.contact_message.section_message'))
                    ->description(__('admin.form.contact_message.section_message_desc'))
                    ->schema([
                        TextInput::make('name')
                            ->label(__('admin.form.contact_message.name'))
                            ->required()
                            ->maxLength(255),
                        TextInput::make('company')
                            ->label(__('admin.form.contact_message.company'))
                            ->maxLength(255),
                        TextInput::make('phone')
                            ->label(__('admin.form.contact_message.phone'))
                            ->required()
                            ->maxLength(50),
                        TextInput::make('email')
                            ->label(__('admin.form.contact_message.email'))
                            ->email()
                            ->maxLength(255),
                    ])
                    ->columns(2),

                Section::make(__('admin.form.contact_message.section_body'))
                    ->schema([
                        TextInput::make('subject')
                            ->label(__('admin.form.contact_message.subject'))
                            ->required()
                            ->maxLength(255),
                        Textarea::make('message')
                            ->label(__('admin.form.contact_message.message'))
                            ->required()
                            ->rows(8)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),

                Section::make(__('admin.form.contact_message.section_status'))
                    ->schema([
                        DateTimePicker::make('read_at')
                            ->label(__('admin.form.contact_message.read_at')),
                    ]),
            ]);
    }
}
