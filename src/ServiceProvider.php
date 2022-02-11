<?php

namespace Reach\MultisitePropagator;

use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{

    protected $commands = [
        Console\Commands\PropagateEntries::class
    ];

}
