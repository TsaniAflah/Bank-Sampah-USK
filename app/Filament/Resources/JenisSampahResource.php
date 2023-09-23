<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JenisSampahResource\Pages;
use App\Filament\Resources\JenisSampahResource\RelationManagers;
use App\Models\JenisSampah;
use Closure;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;

class JenisSampahResource extends Resource
{
    protected static ?string $model = JenisSampah::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-magnifying-glass';

    protected static ?string $navigationLabel = 'Jenis Sampah';

    protected static ?string $navigationGroup = 'Setoran Sampah';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make()
                            ->schema([
                                Forms\Components\TextInput::make('name')
                                    ->label('Jenis sampah')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->reactive()
                                    ->afterStateUpdated(function (\Filament\Forms\Set $set, $state) {
                                        $set('slug', Str::slug($state));
                                    }),

                                Forms\Components\TextInput::make('slug'),

                                Forms\Components\TextInput::make('price')
                                    ->label('Harga')
                                    ->minValue(0)
                                    ->numeric()
                                    ->required(),

                            ])->columns(2),

                        Forms\Components\Section::make('Keterangan')
                            ->schema([
                                Forms\Components\FileUpload::make('image')
                                    ->label('Gambar sampah')
                                    ->columnSpan('full'),
                            ]),
                    ]),

                Forms\Components\Group::make()
                    ->schema([
                        Forms\Components\Section::make('Status')
                            ->schema([
                                Forms\Components\Toggle::make('is_visible')
                                ->label('Tampilkan'),
                                Forms\Components\DatePicker::make('published_at')
                                    ->label('Dibuat pada')
                                    ->required()
                            ])
                    ]),

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('image'),
                Tables\Columns\TextColumn::make('name')
                ->searchable(),
                Tables\Columns\IconColumn::make('is_visible')->boolean(),
                Tables\Columns\TextColumn::make('price')
                ->sortable(),
                Tables\Columns\TextColumn::make('published_at')
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListJenisSampahs::route('/'),
            'create' => Pages\CreateJenisSampah::route('/create'),
            'edit' => Pages\EditJenisSampah::route('/{record}/edit'),
        ];
    }
}
