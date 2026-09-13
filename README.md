# Dino Food &amp; Drink landing page

A single-file, high-conversion landing page for **Dino Food & Drink**, a family-run Vietnamese
kitchen at Shop 2, 466 Boundary Street, Spring Hill QLD 4000.

**Live:** https://brobertuy-beep.github.io/dino-food-and-drink/

## What it is

`index.html` plus `menu.js` (the menu and prices), with no build step, no dependencies and no framework. Open the file
directly in a browser or drop it on any static host.

- Hero with rating proof and three primary CTAs (order / call / directions)
- Stat bar, featured dishes with prices and "% liked" social proof
- Story / about section, six Google review testimonials
- "Good to know" service grid, and a visit block with address, hours and phone
- Sticky mobile action bar so Order/Call are always a thumb away
- `Restaurant` JSON-LD structured data for local SEO
- Fraunces + Inter via Google Fonts; everything else is inline

Verified with no horizontal overflow at 375px, 768px and 1280px. Honours
`prefers-reduced-motion`. Scroll reveals are progressive enhancement, so content stays
visible if JS fails.

## Local preview

No server needed, but if you want one:

```bash
python -m http.server 8000
```

## Deploying

Hosted with GitHub Pages from the `main` branch, root folder.
Settings → Pages → Source: *Deploy from a branch* → `main` / `/ (root)`.

## Editing the menu in Google Sheets (recommended)

The website can read the whole menu, including the six featured cards and the full in-store
menu, from a Google Sheet. Change a price in the sheet and the website shows it within about
5 minutes. No code, and it works from the Google Sheets app on a phone.

If the sheet ever cannot be reached, the website quietly falls back to the list in `menu.js`.

### One-time setup (about 5 minutes)

1. Go to [sheets.google.com](https://sheets.google.com) and create a **Blank spreadsheet**.
   Name it `Dino menu`.
2. **File → Import → Upload**, choose `menu-sheet-template.csv` from this repository.
   Set *Import location* to **Replace current sheet**, then **Import data**.
3. **File → Share → Publish to web**. Under *Link*, pick the sheet tab (not "Entire document")
   and **Comma-separated values (.csv)**. Open *Published content and settings* and make sure
   **Automatically republish when changes are made** is ticked. Click **Publish** and copy the link.
4. Paste that link into `menu.js` between the quote marks on the `window.DINO_SHEET_URL` line,
   then upload `menu.js` to the website again.
5. **Share** the sheet with Mum's Google account as an **Editor**.
   Do not turn on "Anyone with the link can edit".

Publishing makes the sheet readable by anyone who has that CSV link. That is fine for a menu,
which is public anyway, but never put private information in this sheet.

### What each column does

| Column | What to put in it |
|---|---|
| Section | Menu heading the dish sits under, e.g. `Pho`. Dishes with the same Section are grouped. |
| Dish | Dish name. Rows with no Dish are ignored. |
| Price | Counter price, e.g. `$17`, or a size, e.g. `2 for $8.40`. |
| Price 2 | Optional second size, e.g. `3 for $12`. |
| Uber Eats price | Only shown on the featured cards. Leave blank if not on Uber Eats. |
| Show | `No` hides the dish, e.g. when sold out or seasonal. Blank or `Yes` shows it. |
| Featured | `1` to `6` puts the dish in the picture cards at the top, in that order. `1` is also the hero card. |
| Vietnamese name | Optional, shown in small italics. |
| Description | Optional short line in the full menu. |
| Card label, Card description, Card note | Text for featured cards only (the badge, the paragraph, the green line). |
| Section note, Section tag | Put on any one row of a section, e.g. note `Rolls baked on the premises every morning.` |

A dish with no counter price does not appear in the full menu, but can still be a featured
card if it has an Uber Eats price. A featured dish with a counter price and no Uber Eats price
shows an **In store only** label.

Do not rename or delete the header row. Adding new rows anywhere is fine.

## Changing prices in `menu.js` (backup method)

If no Google Sheet link is set, everything on the menu comes from one small file:
**`menu.js`**. You never need to touch `index.html` to change a price.

**On GitHub, from any browser:**

1. Open the repository and click **`menu.js`**.
2. Click the **pencil icon** (Edit this file) at the top right.
3. Find the dish and change the price between the quote marks, e.g. `"$11.50"` to `"$12"`.
   Keep the quote marks and the comma at the end of the line.
4. Scroll down, click **Commit changes**.
5. The website updates in about a minute. Refresh the page to check.

Instructions for adding, hiding and two-size dishes are written at the top of `menu.js`.

If the menu area shows "Our menu is being updated", a quote mark or comma was deleted by
accident. Open the file's **History**, compare with the previous version, and put it back.

To edit, a person needs a GitHub account that has been added under
**Settings → Collaborators** on this repository.

## Uploading to GoDaddy (cPanel Web Hosting)

The website only needs two files: **`index.html`** and **`menu.js`**. They are bundled in
`dino-site-godaddy.zip`. Nothing needs to be installed on the server.

1. In GoDaddy, go to **My Products → Web Hosting → Manage → cPanel Admin**.
2. Open **File Manager** and go into **`public_html`** (or the folder for this domain, if the
   hosting account has more than one site).
3. If an old website is already there, download a copy of it first as a backup.
4. Click **Upload** and choose `dino-site-godaddy.zip`. Back in File Manager, right-click the
   zip, choose **Extract**, and extract into `public_html`. Then delete the zip.
5. Visit the domain and check the menu appears.
6. Make sure SSL is switched on for the domain, so the site opens on `https://`.

After that:

- **Price and menu changes:** edit the Google Sheet. No uploading needed.
- **Design or wording changes:** upload the changed `index.html` over the old one.
- **Changing the sheet link:** edit `menu.js` and upload it over the old one.

When the site moves to its own domain, update the `canonical`, `og:url` and structured data
URLs at the top of `index.html`, which currently point at the GitHub Pages preview.

## Adding photography

The design works photo-free, but every image slot is pre-wired. Drop files into `images/`
and set one CSS custom property on the element:

```html
<div class="dish__art" style="--photo:url('images/crackling-pork-banh-mi.jpg')">
```

Same pattern on `.hero-card__art` (hero dish card) and `.panel-img` (story panel).
The gradient stays underneath as a fallback, so a missing file never leaves a blank box.

## Before this goes public

- [ ] **Trading hours** are listed as Monday to Friday, 9 am to 6 pm. Sources conflicted
      (Google said "opens 9 am Fri", the delivery listing said "Fri 9:30 am to 5:45 pm"),
      and only Friday was ever explicitly stated. Confirm the full week with the owners.
      Hours appear in two places: the Visit card and the JSON-LD block.
- [ ] **Canonical URL** points at the GitHub Pages address. Update it, plus the two
      `og:`/`twitter:` URL tags, if this moves to a custom domain.
- [ ] Add real photography (see above).

## Content sources

Menu items, prices, "% liked" figures, review quotes and service details are taken from the
business's public Google Business Profile and delivery listing. Rating shown is 4.9 from 201
Google reviews.
