# Wiki-Lite

A light weight wiki for use in Laravel 5

## Installation

In your Laravel 5 application, install using [Composer](https://getcomposer.org/).

    composer require savvywombat/wiki-lite

### Configuration

A sample configuration is provided in `config/wiki-lite.php`

By default, the wiki is configured to work as a subdirectory of your site `https://example.com/wiki`.

An anonymous username has been configured, too (currently, the wiki is not integrated into Laravel's authentication system).

### Migrations

Wiki-lite requires two database tables, prefixed with `wiki_lite_`.

The migrations are installed to your project's `database/migrations` directory. Simply run `artisan migrate` to install the databases.

### Views

Wiki-lite installs a layout template which wraps the wiki views allowing you to modify and integrate the layout into your project's layout.

The template is installed into `views/vendor/savvywombat/wiki-lite/`

## Usage

When visiting the wiki index page (`https://example.com/wiki`) for the first time, you will be asked to create a new page with a title.

The wiki uses [CommonMark](https://github.com/commonmark/CommonMark) syntax, with one addition - wiki-links.

### Linking between wiki pages

You can simply enter any page title (or slug) as a link using:

    [[The page title you want to link to]]

When you save the page, you will see a link which takes you to the page you want.

The wiki will also save a link back from the targeted page.

### Editing titles

The wiki uses a UUID for each page, meaning that you can edit page titles and any links to the page's previous titles will still link to the latest version of the page.

### Comparing revisions

Revision comparison uses unified diff format.

## Styling

No styling is provided with this wiki module - but CSS classes have been set on various elements to help with customising the wiki to fit.

## Support

If you are having general issues with this repository, please contact us via
the [SavvyWombat](https://savvywombat.com.au/contact) website.

Please report issues using the [GitHub issue tracker](https://github.com/SavvyWombat/wiki-lite/issues). You are also welcome to fork the repository and submit a pull request.

If you're using this repository, we'd love to hear your thoughts. Thanks!

## Licence

Wiki-Lite is licensed under [The MIT License (MIT)](https://github.com/SavvyWombat/wiki-lite/blob/master/LICENSE).