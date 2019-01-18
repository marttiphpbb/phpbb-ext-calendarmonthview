# phpBB Extension - marttiphpbb Calendar Month View

[Topic on phpbb.com](https://www.phpbb.com/community/viewtopic.php?f=456&t=2487146)

## Description

This phpBB extension provides a Calendar Month View page for the [Calendar extension set](https://github.com/marttiphpbb/phpbb-ext-calendarmono/blob/master/doc/calendar-set.md)

## Screenshot

![Calendar page](doc/calendar.png)

## Requirements

* phpBB 3.2.1+
* PHP 7.1+
* phpBB extension [Menu Items](https://github.com/marttiphpbb/phpbb-ext-menuitems)
* phpBB extension [Calendar Tag](https://github.com/marttiphpbb/phpbb-ext-calendartag)
* phpBB extension [Calendar Mono](https://github.com/marttiphpbb/phpbb-ext-calendarmono)
* PHP calendar extension (PHP compiled with --enable-calendar)

When you don't have PHP compiled with --enable-calendar be sure to
download the build with the vendor directory included (See the latest [Release](https://github.com/marttiphpbb/phpbb-ext-calendarmonthview/releases)) or run
`composer update` in the root of this extension. This way the
missing calendar functions are provided by the
[fisharebest/ext-calendar](https://github.com/fisharebest/ext-calendar) package.

## Quick Install

You can install this on the latest release of phpBB 3.2 by following the steps below:

* Create `marttiphpbb/calendarmonthview` in the `ext` directory.
* Download and unpack the repository into `ext/marttiphpbb/calendarmonthview`
* Enable `Calendar Month View` in the ACP at `Customise -> Manage extensions`.

## Uninstall

* Disable `Calendar Month View` in the ACP at `Customise -> Extension Management -> Extensions`.
* To permanently uninstall, click `Delete Data`. Optionally delete the `/ext/marttiphpbb/calendarmonthview` directory.

## Support

* Report bugs and other issues to the [Issue Tracker](https://github.com/marttiphpbb/phpbb-ext-calendarmonthview/issues).

## License

[GPL-2.0](license.txt)

## More Screenshots

### Menu Link

![Menu Link](doc/menu_link.png)

### ACP: Links

![ACP Links](doc/acp_links.png)

### ACP: Page Rendering

![ACP Page Rendering](doc/acp_page.png)
