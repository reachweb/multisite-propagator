# Multisite Propagator

> Have you ever added a new site in your multisite Statamic setup and had to manually enable and publish entries from the origin? No more! 

## Features

Use this Multisite Propagator to automatically create entries and save a few seconds, minutes or hours.

## How to Install

You can search for this addon in the `Tools > Addons` section of the Statamic control panel and click **install**, or run the following command from your project root:

``` bash
composer require reachweb/multisite-propagator
```

## How to Use

This extension adds a `propagate:entries` command!

Simply use it like this: `php please propagate:entries collection site` and it will work its magic.

Please note that it will create an entry even if it already exists. So use it right at the start of adding a new site to your multisite setup. 

Also we only use it in our setup, your milage may vary. *Data loss may occur.* You have been warned!
