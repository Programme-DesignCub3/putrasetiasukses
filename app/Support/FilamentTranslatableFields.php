<?php

namespace App\Support;

use Awcodes\RicherEditor\Plugins\CodeBlockShikiPlugin;
use Awcodes\RicherEditor\Plugins\EmbedPlugin;
use Awcodes\RicherEditor\Plugins\FullScreenPlugin;
use Awcodes\RicherEditor\Plugins\SourceCodePlugin;
use Closure;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\RichEditor\RichContentRenderer;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use SolutionForest\FilamentTranslateField\Forms\Component\Translate;

class FilamentTranslatableFields
{
    public const RequiredLocale = 'id';

    /**
     * @param  array<int, mixed>|Closure  $schema
     */
    public static function translate(array|Closure $schema, ?string $label = null, int $columns = 3): Translate
    {
        $component = Translate::make()
            ->locales(self::locales())
            ->localeLabels(self::localeLabels())
            ->suffixLocaleLabel()
            ->schema($schema)
            ->columnSpanFull()
            ->columns($columns);

        if ($label !== null) {
            $component->label($label);
        }

        return $component;
    }

    public static function textInput(string $name, string $label, string $locale, bool $required = true): TextInput
    {
        return TextInput::make($name)
            ->label($label)
            ->required($required && self::isRequiredLocale($locale));
    }

    public static function textarea(string $name, string $label, string $locale, int $rows, bool $required = true): Textarea
    {
        return Textarea::make($name)
            ->label($label)
            ->required($required && self::isRequiredLocale($locale))
            ->rows($rows);
    }

    public static function richEditor(string $name, string $label, string $locale, bool $required = true): RichEditor
    {
        $isRequired = $required && self::isRequiredLocale($locale);

        return RichEditor::make($name)
            ->label($label)
            ->required($isRequired)
            ->rule('required', $isRequired)
            ->plugins([
                FullScreenPlugin::make(),
                SourceCodePlugin::make(),
                EmbedPlugin::make(),
                CodeBlockShikiPlugin::make()
                    ->languages(['php', 'blade', 'js', 'ts', 'css', 'html', 'json', 'bash']),
            ])
            ->toolbarButtons([
                ['bold', 'italic', 'underline', 'strike', 'link'],
                ['h2', 'h3'],
                ['alignStart', 'alignCenter', 'alignEnd'],
                ['blockquote', 'codeBlock', 'bulletList', 'orderedList'],
                ['embed'],
                ['table', 'attachFiles', 'sourceCode', 'fullscreen'],
                ['undo', 'redo'],
            ])
            ->fileAttachments(true)
            ->maxHeight('480px')
            ->dehydrateStateUsing(
                fn (mixed $state): mixed => self::isBlankRichContent($state) ? null : $state,
            );
    }

    private static function isBlankRichContent(mixed $state): bool
    {
        if (blank($state)) {
            return true;
        }

        return blank(RichContentRenderer::make($state)->toText());
    }

    public static function isRequiredLocale(string $locale): bool
    {
        return $locale === self::RequiredLocale;
    }

    /**
     * @return list<string>
     */
    public static function locales(): array
    {
        return array_values(array_filter(
            config('localizer.supported_locales', [self::RequiredLocale, 'en', 'zh']),
            is_string(...),
        ));
    }

    /**
     * @return array<string, string>
     */
    public static function localeLabels(): array
    {
        return [
            'id' => 'Indonesia',
            'en' => 'English',
            'zh' => 'Chinese',
        ];
    }
}
