<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SetoranResource\Pages;
use App\Filament\Resources\SetoranResource\RelationManagers;
use App\Models\JenisSampah;
use App\Models\Setoran;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SetoranResource extends Resource
{
    protected static ?string $model = Setoran::class;

    protected static ?string $navigationIcon = 'heroicon-o-archive-box-arrow-down';

    protected static ?string $navigationGroup = 'Setoran Sampah';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Wizard::make([
                    Forms\Components\Wizard\Step::make('Penyetor')
                        ->schema([
                            Forms\Components\TextInput::make('number')
                                ->default('SETOR-' . random_int(100000, 9999999))
                                ->disabled()
                                ->dehydrated()
                                ->required(),

                            Forms\Components\Select::make('nasabah_id')
                                ->relationship('nasabah', 'name')
                                ->searchable()
                                ->required(),

                            Forms\Components\MarkdownEditor::make('notes')
                                ->columnSpanFull()

                        ])->columns(2),

                    Forms\Components\Wizard\Step::make('Setoran')
                        ->schema([
                            Forms\Components\Repeater::make('items')
                            ->relationship()
                            ->schema([
                                Forms\Components\Select::make('jenis_sampah_id')
                                    ->label('Jenis sampah')
                                    ->options(JenisSampah::query()->pluck('name', 'id'))
                                    ->required()
                                    ->reactive()
                                    ->afterStateUpdated(fn($state, Forms\Set $set) =>
                                    $set('unit_price', JenisSampah::find($state)?->price ?? 0)),

                                Forms\Components\TextInput::make('total_weight')
                                    ->label('Total Berat')
                                    ->numeric()
                                    ->required(),

                                Forms\Components\TextInput::make('unit_price')
                                    ->label('Harga satuan')
                                    ->numeric()
                                    ->required(),

                                Forms\Components\Placeholder::make('total_income')
                                    ->label('Total pendapatan')
                                    ->content(function ($get) {
                                        return $get('total_weight') * $get('unit_price');
                                    })
                            ])->columns(4)
                        ])

                ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('number')
                    ->searchable()
                    ->sortable(),

                Tables\Columns\TextColumn::make('nasabah.name')
                    ->searchable()
                    ->sortable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('total_weight')
                    ->searchable()
                    ->sortable()
                    ->summarize([
                        Tables\Columns\Summarizers\Sum::make()
                    ]),

                Tables\Columns\TextColumn::make('total_income')
                    ->searchable()
                    ->sortable()
                    ->summarize([
                        Tables\Columns\Summarizers\Sum::make()
                            ->money()
                    ]),

                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal setor')
                    ->date()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make()
                ])
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
            'index' => Pages\ListSetorans::route('/'),
            'create' => Pages\CreateSetoran::route('/create'),
            'edit' => Pages\EditSetoran::route('/{record}/edit'),
        ];
    }
}
