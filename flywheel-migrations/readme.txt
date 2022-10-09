=== Flywheel Migrations ===
Contributors: getflywheel, blogvault, akshatc
Tags: flywheel, migration
Requires at least: 4.0
Tested up to: 6.0
Requires PHP: 5.4.0
Stable tag: 4.78
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Ready to migrate to Flywheel? We’re super excited to take care of your site and handle all of the hassles of hosting, including security, performance, and updates. Let’s get you migrated over and on your way to creating and managing WordPress sites with ease, so you can keep focusing on doing your best work!

== Description ==

Ready to migrate to Flywheel? We’re super excited to take care of your site and handle all of the hassles of hosting, including security, performance, and updates. Let’s get you migrated over and on your way to creating and managing WordPress sites with ease, so you can keep focusing on doing your best work!

The robots inside this plugin do all of the heavy lifting for you! With clearly defined fields and email notifications, you don't have to watch the progress bar tick by. All you need to kick off a migration is a few Flywheel specific fields and you're on your way.

Not sure where to start? Visit our [help doc](https://getflywheel.com/wordpress-support/migrating-your-site-from-another-host-to-flywheel/) to walk you through step by step instructions.

Need some help? Reach out to our [technical onboarding team](https://app.getflywheel.com/tickets/new?source=blogvault) or [let us migrate your site to Flywheel](https://app.getflywheel.com/migration) for free!

By using this plugin you are agreeing to Blogvault’s [Terms of Service](https://blogvault.net/tos/)
[youtube https://www.youtube.com/watch?v=SyDhfrg6NBc]

== FREQUENTLY ASKED QUESTIONS ==

=Can I still use this plugin if I don’t have a Flywheel account?=
You need a Flywheel account to use the plugin, but it’s easy and free to create one! [Create an account here](https://app.getflywheel.com/signup). 

=What information will the plugin ask for?=
All we need is your email address and a few site details, including the Flywheel dashboard URL, temporary URL, and privacy mode credentials. Check out this [migration help doc](https://getflywheel.com/wordpress-support/migrating-your-site-from-another-host-to-flywheel/) for guidance!

=Is Multisite Network supported with this plugin?=
Yes, this plugin is capable of moving full Multisite Networks! To move a full network, make sure to install and activate the Flywheel Migrations plugin in the Network Admin of the multisite you would like to migrate.

=Can I migrate a site into or out of a Multisite Network using this plugin?=
No, this plugin is designed to migrate one complete WordPress install. It does not support single WordPress installs being migrated into Multisite Networks or subsites out of a multisite.

=How long does it take to migrate a website?=
Sites come in all shapes and sizes. Because of this, migrations can range anywhere from 30 minutes to several hours.

=What happens if I run into an error after the migration is complete?=
We always recommend clicking through your site for quality assurance. No matter what, we’re here to help! Whether it be a failed migration or you find something amiss while looking over your site, reach out to our [technical onboarding team](https://app.getflywheel.com/tickets/new?source=blogvault) or [fill out a migration request](https://app.getflywheel.com/migration) to have our team take it from there.

=Other than running the plugin, is there anything else I need to do?=
Once the migration completes, you will still need to [take your site live](https://getflywheel.com/wordpress-support/go-live-flywheel/) by updating your DNS to point to our servers. If you have any custom configurations on your current server, our [support team](https://getflywheel.com/wordpress-support/how-do-i-get-help/) can assist you in setting those up on your Flywheel server.

=Do I need to leave the window open while the migration is processing?=
Nope! Sit back and relax while robots move your site. Once your migration is complete, we’ll send a completion email to your inbox.

=Do you exclude any plugins during the migration?=
The plugin does exclude most common backup, caching, security, and performance plugins during the migration. This is to eliminate conflicts or redundancy with Flywheel features! That said, we do not ban any plugins from being installed. You are always welcome to reinstall any excluded plugins, but bear in mind performance may be impacted.

== INSTALLATION ==

If you have WordPress 2.7 or above you can install Flywheel Migrations from within WordPress

1. Navigate to the plugins page in the WordPress dashboard of the site you want to migrate
2. Select “Add New”
3. Search for “Flywheel Migrations”
4. Find the plugin and select “Install”
5. Once the plugin is installed you can activate it and begin migrating your site!

== CHANGELOG ==
= 4.72 =
* Better handling for plugin, theme infos
* Sync Improvements

= 4.69 =
* Improved network call efficiency for site info callbacks.

= 4.68 =
* Removing use of constants for arrays for PHP 5.4 support.
* Post type fetch improvement.

= 4.65 =
* Robust handling of requests params.
* Callback wing versioning.

= 4.62 =
* MultiTable Sync in single callback functionality added.
* Improved host info
* Fixed services data fetch bug
* Fixed account listing bug in wp-admin

= 4.58 =
* Better Handling of error message from Server on signup
* Added Support for Multi Table Callbacks

= 4.35 =
* Improved scanfiles and filelist api

= 4.31 =
* Fetching Mysql Version
* Robust data fetch APIs
* Core plugin changes
* Sanitizing incoming params

= 4.25 =
* Updated links and added a step-by-step migration video under Description section

= 4.1 =
* First release of Flywheel Plugin
