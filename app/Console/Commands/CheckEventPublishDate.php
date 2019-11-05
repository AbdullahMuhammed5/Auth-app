<?php

namespace App\Console\Commands;

use App\Event;
use Illuminate\Console\Command;
use Kreait\Firebase\Database\RuleSet;
use Kreait\Firebase\Factory;

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
     * @throws \Kreait\Firebase\Exception\ApiException
     */
    public function handle()
    {
        // update status
        Event::DateHasCame()->update(['published' => true]);
        Event::DateNotComeYet()->update(['published' => false]);

        // get published news and push them to firebase
        $publishedEvents = Event::where('published' , true)->get();
        $unPublishedEvents = Event::where('published' , false)->get();

        $firebase = (new Factory)
            ->withServiceAccount(base_path().'/firebase_credentials.json')
            ->withDatabaseUri('https://news-app-f607c.firebaseio.com/');

        $database = $firebase->createDatabase();
        $fbEvents = $database->getReference("events")->getValue();

        if (is_array($fbEvents)){ // check if there is events in firebase
            foreach ($fbEvents as $key => $value){ // get ids to compare later with the new events
                $ids[] = $value['id'];
            }
            foreach ($publishedEvents as $event){ // check if not exist in firebase then add it
                if (! in_array($event->id, $ids)){
                    $database->getReference('events')->push($event);
                }
            }
//            foreach ($unPublishedEvents as $event){ // check if not exist in firebase then add it
//                if (in_array($event->id, $ids)){
//                    $database->getReference('events')->push($event);
//                }
//            }
        } else{ // work first time when no events in firebase
            foreach ($publishedEvents as $event){
                $database->getReference('events')->push($event);
            }
        }

        $this->info('All events status has been checked and updated!');
    }
}
