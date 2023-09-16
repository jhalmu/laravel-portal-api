<?php

namespace App\Filament\Resources\TagResource\RelationManagers;

use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class PostsRelationManager extends RelationManager
{
    protected static string $relationship = 'posts';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Main content')->schema(
                [
                TextInput::make('title')
                ->live(onBlur: true)
                ->required()->minLength(1)->maxLength(150)
                ->afterStateUpdated(function (string $operation, $state, Set $set) {
                if ($operation === 'edit')
                return;
                $set('slug', Str::slug($state));
                }),
                TextInput::make('slug')
                ->required()->unique(ignoreRecord: true)->maxLength(150),
                RichEditor::make('body')
                ->required()->fileAttachmentsDirectory('posts/images')->columnSpanFull()
                ]

                )->columns(2),

                Section::make('Meta')->schema(
                [
                FileUpload::make('image')->image()->directory('posts/thumbnails'),
                DateTimePicker::make('published_at')->nullable(),
                Checkbox::make('featured'),
                Select::make('user_id')
                ->relationship('author', 'name')
                ->live(onBlur: true)
                ->searchable()
                ->required()
                ->preload(),

                Select::make('tags')
                ->relationship('tags', 'title')
                ->multiple()
                ->searchable()
                ->preload(),
                ]

                ),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                   ImageColumn::make('image'),
                   TextColumn::make('title')->sortable()->searchable(),
                   TextColumn::make('slug')->sortable()->searchable(),
                   TextColumn::make('author.name')->sortable()->searchable(),
                   TextColumn::make('published_at')->date()->sortable()->searchable(),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
                Filter::make('is_featured'),
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn (Builder $query) => $query->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]));
    }
}
