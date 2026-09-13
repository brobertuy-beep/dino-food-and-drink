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

## Changing prices and dishes

Everything on the menu, including the six featured cards and the full in-store menu, comes
from one small file: **`menu.js`**. You never need to touch `index.html` to change a price.

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
