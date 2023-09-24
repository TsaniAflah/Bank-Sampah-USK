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

    protected static ?string $navigationLabel = 'Setoran';

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
                                        ->label('Jenis Sampah')
                                        ->options(JenisSampah::query()->pluck('name', 'id'))
                                        ->required()
                                        ->reactive()
                                        ->afterStateUpdated(fn($state, Forms\Set $set) => $set('unit_price', JenisSampah::find($state)?->price ?? 0)),

                                    Forms\Components\TextInput::make('quantity')
                                        ->label('Total Berat')
                                        ->numeric()
                                        ->live()
                                        ->dehydrated()
                                        ->rules('regex:/^\d{1,6}(\.\d{0,2})?$/')
                                        ->required()
                                        ->reactive()
                                        ->afterStateUpdated(function (\Filament\Forms\Set $set, $state, $get) {
                                            $set('total_income', ($state * $get('unit_price')));
                                        }),

                                    Forms\Components\TextInput::make('unit_price')
                                        ->label('Harga Satuan')
                                        ->numeric()
                                        ->required(),

//                                    Forms\Components\Placeholder::make('total_income')
//                                        ->label('Total Pendapatan')
//                                        ->content(function ($get) {
//                                            $quantity = floatval($get('quantity'));
//                                            $unitPrice = floatval($get('unit_price'));
//                                            return $quantity * $unitPrice;
//                                        }),

                                    Forms\Components\TextInput::make('total_income')
                                        ->label('Total Pendapatan')
                                    ->disabled()

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

                //Tables\Columns\TextColumn::make('notes'),

                //Tables\Columns\TextColumn::make('total_weight'),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Tanggal setor')
                    ->date()
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\ActionGroup::make([

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
