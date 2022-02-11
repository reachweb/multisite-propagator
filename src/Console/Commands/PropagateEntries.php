<?php

namespace Reach\MultisitePropagator\Console\Commands;

use Illuminate\Console\Command;
use Statamic\Facades\Stache;
use Statamic\Console\EnhancesCommands;
use Statamic\Console\RunsInPlease;
use Illuminate\Support\Facades\Cache;
use Reach\MultisitePropagator\Helpers\MultisitePropagatorHelper;
use Reach\MultisitePropagator\Exceptions\PropagateException;

class PropagateEntries extends Command
{
    use RunsInPlease, EnhancesCommands;

    protected $name = 'statamic:propagate';
    protected $signature = 'statamic:propagate:entries {collection} {site}';
    protected $description = 'Propagate your existing entries to another site';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $collection = $this->argument('collection');
        $site = $this->argument('site');

        $confirmed = $this->confirm("I will now create entries for [<comment>{$site}</comment>], for the [<comment>{$collection}</comment>] collection. THIS WILL REWRITE EXISTING ENTRIES. Is this okay?");
        
        if (! $confirmed) {
            $this->crossLine('You stopped the prop before I even started!');
            return;
        }

        Stache::disableUpdatingIndexes();

        $this->comment('Creating...');

        try {
            (new MultisitePropagatorHelper($collection, $site))->propagate();
        } catch (PropagateException $e) {
            $this->crossLine($e->getMessage());
            return;
        }

        $this->checkLine('Entries proped and ready to go!');

        Cache::clear();
        $this->checkLine('Cache cleared.');
        Stache::clear();
        $this->checkLine('Stache cleared.');
        
    }

}