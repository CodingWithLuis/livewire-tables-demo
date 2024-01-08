<?php

namespace App\Livewire;

use App\Exports\UsersExport;
use App\Models\User;
use Maatwebsite\Excel\Facades\Excel;
use RamonRietdijk\LivewireTables\Actions\Action;
use RamonRietdijk\LivewireTables\Columns\Column;
use RamonRietdijk\LivewireTables\Columns\DateColumn;
use RamonRietdijk\LivewireTables\Columns\ViewColumn;
use RamonRietdijk\LivewireTables\Filters\DateFilter;
use RamonRietdijk\LivewireTables\Livewire\LivewireTable;

class UsersTable extends LivewireTable
{
    protected string $model = User::class;

    public function columns(): array
    {
        return [
            Column::make('Usuario', 'name'),
            Column::make('Email', 'email'),
            DateColumn::make('Fecha de Creación', 'created_at'),
            ViewColumn::make('Acciones', 'users.actions'),
        ];
    }

    protected function filters(): array
    {
        return [
            DateFilter::make('Fecha Creacion', 'created_at'),
        ];
    }

    protected function actions(): array
    {
        return [
            Action::make('Exportar Todo', 'export_all', function () {
                $collection = $this->appliedQuery()->get();

                return Excel::download(new UsersExport($collection), 'users-report.xlsx');
            })->standalone(),
        ];
    }
}
