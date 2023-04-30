<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TicketResource\Pages;
use App\Filament\Resources\TicketResource\RelationManagers;
use App\Models\Customer;
use App\Models\IssueCategory;
use App\Models\IssueSources;
use App\Models\Ticket;
use App\Models\TicketStatuses;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Form;
use Filament\Resources\Resource;
use Filament\Resources\Table;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use pxlrbt\FilamentExcel\Actions\Tables\ExportBulkAction;

class TicketResource extends Resource
{
    protected static ?string $model = Ticket::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';
    protected static ?string $navigationGroup = 'Help Desk';


    protected static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('customer_id')
                    ->label('select customer')
                    ->options(Customer::all()->pluck('name', 'id'))
                    ->searchable(),
                Select::make('issue_source_id')
                    ->label('Issue Source')
                    ->options(IssueSources::all()->pluck('name', 'id'))
                    ->searchable(),
                Select::make('issue_category_id')
                    ->label('Issue Category')
                    ->options(IssueCategory::all()->pluck('name', 'id'))
                    ->searchable(),
                Select::make('ticket_status_id')
                    ->label('Ticket Status')
                    ->options(TicketStatuses::all()->pluck('name', 'id'))
                    ->searchable(),
                TextInput::make('department'),
                TextInput::make('comment'),


            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make(name: 'id')->sortable(),
                Tables\Columns\TextColumn::make(name: 'customer.name')->label('Name')->searchable(),
                Tables\Columns\TextColumn::make(name: 'issueSource.name')->searchable(),
                Tables\Columns\TextColumn::make(name: 'issueCategory.name')->searchable(),
                Tables\Columns\TextColumn::make(name: 'ticketStatus.name')->searchable(),
                Tables\Columns\TextColumn::make(name: 'department')->searchable(),
                Tables\Columns\TextColumn::make('created_at')->sortable(),


            ])->defaultSort(column: 'id', direction: 'asc')
            ->filters([
                Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    }),

                    Filter::make('Open Tickets')
                    ->query(fn (Builder $query): Builder => $query->where('ticket_status_id', 1)),

                    Filter::make('Closed Tickets')
                    ->query(fn (Builder $query): Builder => $query->where('ticket_status_id', 2)),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
                ExportBulkAction::make() 
                ->deselectRecordsAfterCompletion(),                
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
            'index' => Pages\ListTickets::route('/'),
            'create' => Pages\CreateTicket::route('/create'),
            'edit' => Pages\EditTicket::route('/{record}/edit'),
        ];
    }
}
