<?php

namespace App\Filament\Widgets;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Production;
use Filament\Support\Icons\Heroicon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Jumlah Customer', Customer::count())
                ->color('primary')
                ->icon('heroicon-o-users'),
            Stat::make('Produksi Selesai', Production::where('status', 'completed')->count())
                ->color('success')
                ->icon('heroicon-o-check-circle'),
            Stat::make('Produksi Berjalan', Production::where('status', 'in_progress')->count())
                ->color('warning')
                ->icon('heroicon-o-clock'),
            Stat::make("Invoice", Invoice::count())
                ->color("secondary"),
            Stat::make("Invoice Draft", Invoice::where("status", "draft")->count())
                ->color("secondary"),
            Stat::make("Invoice DP", Invoice::where("status", "dp")->count())
                ->color("secondary")
        ];
    }
}
