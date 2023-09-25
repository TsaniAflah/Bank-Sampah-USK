<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PostResource\Pages;
use App\Filament\Resources\PostResource\RelationManagers;
use App\Models\Post;
use Closure;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Table;
use Filament\Tables;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class PostResource extends Resource
{
    protected static ?string $model = Post::class;

    protected static ?string $navigationLabel = 'Postingan';

    protected static ?string $navigationIcon = 'heroicon-o-newspaper';

    protected static ?string $navigationGroup = 'Post';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\Grid::make(2)
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Judul')
                                    ->required()
                                    ->maxLength(2048)
                                    ->reactive()
                                    ->afterStateUpdated(function (\Filament\Forms\Set $set, $state) {
                                        $set('slug', Str::slug($state));
                                    }),
                                Forms\Components\TextInput::make('slug')
                                    ->required()
                                    ->maxLength(2048)
                            ])
                        ,
                        Forms\Components\RichEditor::make('body')
                            ->label('Konten')
                            ->required(),
                        Forms\Components\Toggle::make('active')
                            ->label('Tampilkan')
                            ->required(),
                        Forms\Components\DateTimePicker::make('published_at')
                            ->label('Dibuat pada'),
                    ])->columnSpan(8),

                Forms\Components\Card::make()
                    ->schema([
                        Forms\Components\FileUpload::make('thumbnail')
                        ->label('Sampul')
                        ->image(),
                        Forms\Components\Select::make('category_id')
                            ->multiple()
                            ->relationship('categories', 'title')
                            ->required(),
                    ])->columnSpan(4)

            ])->columns(12);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('thumbnail'),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\IconColumn::make('active')
                    ->boolean(),
                Tables\Columns\TextColumn::make('published_at')
                    ->dateTime()
                    ->sortable(),
                //Tables\Columns\TextColumn::make('user.name'),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->timezone('Asia/Jakarta')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
}
