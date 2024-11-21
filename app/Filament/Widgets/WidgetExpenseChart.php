<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Flowframe\Trend\Trend;
use Flowframe\Trend\TrendValue;

class WidgetExpenseChart extends ChartWidget
{
    protected static ?string $heading = 'Pengeluaran';
    protected static string $color = 'danger';

    use InteractsWithPageFilters;

    protected function getData(): array
    {
        $startDate = !is_null($this->filters['startDate'] ?? null)
            ? Carbon::parse($this->filters['startDate'])
            : Carbon::createFromFormat('Y-m-d', '2000-01-01'); // Default far-past date

        $endDate = !is_null($this->filters['endDate'] ?? null)
            ? Carbon::parse($this->filters['endDate'])
            : now();

        $data = Trend::query(Transaction::expense())
            ->dateColumn('date_transaction')
            ->between(
                start: $startDate,
                end: $endDate,
            )
            ->perDay()
            ->sum('amount');

        return [
            'datasets' => [
                [
                    'label' => 'Pengeluaran Per Hari',
                    'data' => $data->map(fn(TrendValue $value) => $value->aggregate),
                ],
            ],
            'labels' => $data->map(fn(TrendValue $value) => $value->date),
        ];
    }


    protected function getType(): string
    {
        return 'line';
    }
}
