<?php
namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Stock;
use Illuminate\Support\Facades\Log;

class UpdateStockStatus extends Command
{
    protected $signature = 'stock:update';
    
    protected $description = 'Update stock status based on in_stock_date';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        Stock::whereDate('in_stock_date', now()->toDateString())
            ->update(['in_stock' => true]);
            
        Stock::whereDate('in_stock_date', '<>', now()->toDateString())
            ->update(['in_stock' => false]);

        Log::info('Stock status update completed.');
    }
}