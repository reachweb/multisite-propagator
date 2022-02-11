<?php

namespace Reach\MultisitePropagator\Helpers;

use Reach\MultisitePropagator\Exceptions\PropagateException;
use Statamic\Facades\Collection;
use Statamic\Entries\Collection as StatamicCollection;
use Statamic\Facades\Entry;
use Statamic\Facades\Site;
use Statamic\Sites\Site as StatamicSite;

class MultisitePropagatorHelper
{
    // The collection to search for
    protected $collection;

    // The site to propagate to
    protected $site;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($handle, $site)
    {
        $this->collection = $this->findCollection($handle);
        $this->site = $this->findSite($site);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function propagate()
    {
        $entries = $this->collection->queryEntries()->get();
        $entries->each(function($entry) {
            Entry::make()
                ->collection($this->collection)
                ->origin($entry)
                ->locale($this->site)
                ->slug($entry->slug())
                ->save();
        });
    }

    protected function findCollection(string $handle): StatamicCollection
    {
        $collection = Collection::findByHandle($handle);
        if ($collection == null) {
            throw new PropagateException('I cannot find this collection bro! Did you use the correct handle?');
        }   
        return $collection;
    }

    protected function findSite(string $handle): StatamicSite
    {
        $site = Site::get($handle);
        if ($site == null) {
            throw new PropagateException('There is no such site bro! Remember, use the handle, not the name!');
        }
        return $site;
    }
}
