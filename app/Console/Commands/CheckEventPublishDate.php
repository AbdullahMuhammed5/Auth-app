<?php

namespace App\Console\Commands;

use App\Event;
use Illuminate\Console\Command;

class CheckEventPublishDate extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:updateStatus';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update event status to publish in case it\'s start date has come or to unpublished if it\'s date did not come yet or came and passed';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        date_default_timezone_set('Africa/Cairo');
        Event::DateHasCame()->update(['published' => true]);
        Event::DateNotComeYet()->update(['published' => false]);
        $this->info('All events status has been checked and updated!');
    }
}
