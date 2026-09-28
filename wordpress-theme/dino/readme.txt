=== Dino Food & Drink ===

Single page WordPress theme for Dino Food & Drink, Shop 2, 466 Boundary Street,
Spring Hill QLD 4000.

== Installing on GoDaddy WordPress hosting ==

1. Log in to WordPress at yourdomain.com.au/wp-admin
2. Go to Appearance > Themes > Add New > Upload Theme
3. Choose dino-wordpress-theme.zip and click Install Now
4. Click Activate
5. Go to Settings > Reading and set "Your homepage displays" to "Your latest posts".
   This theme is a single page, so that setting shows the restaurant page.
6. If GoDaddy shows an old version of the page, clear the cache from the
   GoDaddy or WordPress toolbar at the top of the screen.

== Changing the menu and prices ==

Prices come from a published Google Sheet. Go to:

  Appearance > Customize > Dino Food & Drink

and paste the sheet's "Publish to web" CSV link into "Google Sheet CSV link".
After that, editing a price in the sheet updates the website within about 5 minutes.
Nobody needs to log in to WordPress to change a price.

If that box is left empty, the menu in js/menu.js is used instead. If the sheet is ever
unreachable, the site quietly falls back to that same file, so the menu never disappears.

== Other settings in the Customizer ==

* Phone number: used by every Call button and the phone link
* Uber Eats link: used by the Order online buttons
* Google Maps link: used by Get directions and the address

== Changing the wording or design ==

The page text lives in index.php and the design lives in style.css. Both can be edited
under Appearance > Theme File Editor, or through SFTP. Keep a copy before editing.

== Files ==

* index.php      the page
* 404.php        shown when a link is broken
* functions.php  loads the fonts, styles and scripts, and adds the Customizer settings
* style.css      all of the design
* js/menu.js     the menu and prices used when no Google Sheet is connected
* js/site.js     reads the Google Sheet and builds the menu on the page

== Notes ==

This theme has no screenshot image, so WordPress shows a grey placeholder in the theme
list. That is cosmetic only. To add one, save a 1200x900 PNG of the homepage into the
theme folder as screenshot.png.

The theme is generated from the plain HTML version of the site. If both are in use, change
one and regenerate the other rather than editing them separately.
