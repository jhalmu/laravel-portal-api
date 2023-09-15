<?php

namespace App\Filament\Resources;

use App\Models\Tag;
use Filament\Forms;
use App\Models\Post;
use Filament\Tables;
use Filament\Forms\Set;
use Filament\Forms\Form;
use Filament\Tables\Table;
use Illuminate\Support\Str;
use Filament\Resources\Resource;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Section;
use Filament\Pages\Actions\EditAction;
use Filament\Forms\Components\Checkbox;
use Filament\Tables\Columns\TextColumn;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Columns\ImageColumn;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Columns\SelectColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Columns\CheckboxColumn;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Forms\Components\DateTimePicker;
use Filament\Tables\Actions\DeleteBulkAction;
use App\Filament\Resources\PostResource\Pages;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use App\Filament\Resources\PostResource\Pages\EditPost;
use App\Filament\Resources\PostResource\Pages\ListPosts;
use App\Filament\Resources\PostResource\Pages\CreatePost;
use App\Filament\Resources\PostResource\RelationManagers;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Main content')->schema(
                    [
                        TextInput::make('title')
                            ->live()
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                ImageColumn::make('image'),
                TextColumn::make('title')->sortable()->searchable(),
                TextColumn::make('slug')->sortable()->searchable(),
                TextColumn::make('author.name')->sortable()->searchable(),
                TextColumn::make('published_at')->date()->sortable()->searchable(),
                CheckboxColumn::make('featured'),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPosts::route('/'),
            'create' => Pages\CreatePost::route('/create'),
            'edit' => Pages\EditPost::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
