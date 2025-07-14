<?php

namespace App\Filament\Resources;

use App\Filament\Resources\VoucherResource\Pages;
use App\Models\Voucher;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class VoucherResource extends Resource
{
    protected static ?string $model = Voucher::class;

    protected static ?string $navigationIcon = 'heroicon-o-ticket';
    protected static ?string $navigationLabel = 'Vouchers';
    protected static ?string $pluralLabel = 'Vouchers';
    protected static ?string $modelLabel = 'Voucher';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Forms\Components\TextInput::make('code')
                ->label('Voucher Code')
                ->required()
                ->unique(ignoreRecord: true)
                ->maxLength(50),

            Forms\Components\TextInput::make('name')
                ->label('Name')
                ->maxLength(100),

            Forms\Components\RichEditor::make('description')
                ->label('Description')
                ->toolbarButtons([
                    'bold', 'italic', 'underline', 'strike',
                    'bulletList', 'orderedList', 'link',
                    'blockquote', 'codeBlock', 'h2', 'h3', 'hr',
                ])
                ->columnSpanFull(),

            Forms\Components\Select::make('type')
                ->label('Discount Type')
                ->options([
                    'percentage' => 'Percentage',
                    'fixed' => 'Fixed Amount',
                ])
                ->required(),

            Forms\Components\TextInput::make('value')
                ->label('Discount Value')
                ->numeric()
                ->required(),

            Forms\Components\TextInput::make('min_spend')
                ->label('Minimum Spend')
                ->numeric()
                ->default(0),

            Forms\Components\TextInput::make('usage_limit')
                ->label('Total Usage Limit')
                ->numeric(),

            Forms\Components\TextInput::make('per_user_limit')
                ->label('Per User Limit')
                ->numeric(),

            Forms\Components\DateTimePicker::make('start_date')
                ->label('Start Date'),

            Forms\Components\DateTimePicker::make('expiry_date')
                ->label('Expiry Date'),

            Forms\Components\Toggle::make('is_active')
                ->label('Active')
                ->default(true),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')->searchable(),
                Tables\Columns\TextColumn::make('type')->label('Type'),
                Tables\Columns\TextColumn::make('value')->label('Discount'),
                Tables\Columns\TextColumn::make('min_spend')->label('Min Spend'),
                Tables\Columns\IconColumn::make('is_active')->boolean()->label('Active'),
                Tables\Columns\TextColumn::make('start_date')->dateTime(),
                Tables\Columns\TextColumn::make('expiry_date')->dateTime(),
                Tables\Columns\TextColumn::make('created_at')->dateTime()->label('Created'),
            ])
            ->filters([
                Tables\Filters\TernaryFilter::make('is_active')->label('Active Status'),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVouchers::route('/'),
            'create' => Pages\CreateVoucher::route('/create'),
            'edit' => Pages\EditVoucher::route('/{record}/edit'),
        ];
    }
}
