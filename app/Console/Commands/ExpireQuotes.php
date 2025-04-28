<?php

namespace App\Console\Commands;

use App\Actions\Quotes\UpdateQuoteAction;
use App\Enums\QuoteStatusEnum;
use Illuminate\Console\Command;
use Carbon\Carbon;
use App\Models\Quote;

class ExpireQuotes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'quotes:expire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check and update expired quotes based on created_at date.';

    /**
     * Execute the console command.
     */
    public function handle(UpdateQuoteAction $updateQuoteAction)
    {
        // cutoff date (30 days ago)
        $cutoffDate = Carbon::now()->subDays(30);

        // get the expired quotes
        $expiredQuotes = Quote::pending()
            ->where('created_at', '<', $cutoffDate)
            ->get();

        $totalQuotes = $expiredQuotes->count();

        if ($totalQuotes == 0) {
            $this->info("No expired quotes found");
            return;
        }

        // create a progress bar
        $this->info("Processing {$totalQuotes} expired quotes...");
        $bar = $this->output->createProgressBar($totalQuotes);
        $bar->start();

        // loop the quotes and update the status
        foreach ($expiredQuotes as $quote) {
            $updateQuoteAction->execute([
                'id' => $quote->id, 'status' => 'expired'
            ],
            'Record updated from quotes:expire command'
            );
            $bar->advance();
        }

        // finish the progress bar
        $bar->finish();
        $this->newLine();

        // success message
        $this->info("{$totalQuotes} quotes have been marked as expired.");
    }
}
