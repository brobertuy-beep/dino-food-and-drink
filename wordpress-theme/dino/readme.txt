=== Dino Food & Drink ===

Single page WordPress theme for Dino Food & Drink, Shop 2, 466 Boundary Street,
Spring Hill QLD 4000.

== Installing or updating on GoDaddy WordPress hosting ==

1. Log in at dinofoodanddrink.com.au/wp-admin
2. Appearance > Themes > Add New > Upload Theme
3. Choose dino-wordpress-theme.zip and click Install Now
4. If WordPress says the theme already exists, click "Replace current with uploaded"
5. Activate it if it is not already active
6. Click Flush Cache in the black bar at the top of the screen

Updating the theme never touches the menu. The menu is kept in the WordPress
database, not in the theme files.

== Changing the menu and prices ==

In the dashboard, click Menu & Prices (the fork and knife icon in the left menu).
When viewing the website while logged in, the black bar at the top also has an
"Edit menu & prices" link.

* Change a price: type the new price, then press Save menu at the bottom.
* Sold out or seasonal: untick "Show on website". Tick it again to bring it back.
* New dish: press "+ Add a dish to this section".
* Change the order: use the up and down arrows.
* Remove a dish: press Remove.
* Featured cards at the top of the menu: open "More options" on a dish and pick
  a Featured card number from 1 to 6. Number 1 is also the big card at the top
  of the page.

The website shows the change as soon as Save menu is pressed. No cache flushing
needed for menu changes.

If something is entered wrongly, nothing is saved and the screen says what to fix.

== Undo ==

Every save keeps a copy of the menu from just before it, the last 15 saves.
They are listed under "Undo a change" at the bottom of Menu & Prices. Press
"Restore this menu" to go back. Restoring also keeps the current menu, so you
can always switch back again.

== Giving the owners their own login ==

Users > Add New User, and choose the role "Editor". Editors can change the menu
but cannot install themes, plugins or change site settings, which keeps the
site safe from accidental damage.

== Other settings ==

Appearance > Customize > Dino Food & Drink holds the phone number, the Uber Eats
link and the Google Maps link.

The page wording and design live in the theme files. Ask the developer to change
those, rather than using the Theme File Editor, because a theme update would
replace any edits made there.

== Files ==

* functions.php         loads the fonts, styles and scripts, Customizer settings
* inc/admin-menu.php    the Menu & Prices page, the saved menu, and the menu feed
* inc/menu-seed.php     the starting menu, used until the first save (generated)
* js/admin-menu.js      the Menu & Prices editing screen
* css/admin-menu.css    styling for the Menu & Prices screen
* js/site.js            builds the menu on the website (generated)
* js/menu.js            backup menu, shown only if the menu feed cannot be reached (generated)
* index.php, 404.php    the page and the not-found page (generated)
* style.css             the design (generated)

Generated files are built from the plain HTML site by tools/build-theme.js in the
project repository. Change the source and rebuild, rather than editing them here.
