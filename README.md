# Dino Food &amp; Drink — landing page

A single-file, high-conversion landing page for **Dino Food & Drink**, a family-run Vietnamese
kitchen at Shop 2, 466 Boundary Street, Spring Hill QLD 4000.

**Live:** https://brobertuy-beep.github.io/dino-food-and-drink/

## What it is

One self-contained `index.html` — no build step, no dependencies, no framework. Open the file
directly in a browser or drop it on any static host.

- Hero with rating proof and three primary CTAs (order / call / directions)
- Stat bar, featured dishes with prices and "% liked" social proof
- Story / about section, six Google review testimonials
- "Good to know" service grid, and a visit block with address, hours and phone
- Sticky mobile action bar so Order/Call are always a thumb away
- `Restaurant` JSON-LD structured data for local SEO
- Fraunces + Inter via Google Fonts; everything else is inline

Verified with no horizontal overflow at 375px, 768px and 1280px. Honours
`prefers-reduced-motion`. Scroll reveals are progressive enhancement — content stays
visible if JS fails.

## Local preview

No server needed, but if you want one:

```bash
python -m http.server 8000
```

## Deploying

Hosted with GitHub Pages from the `main` branch, root folder.
Settings → Pages → Source: *Deploy from a branch* → `main` / `/ (root)`.

## Adding photography

The design works photo-free, but every image slot is pre-wired. Drop files into `images/`
and set one CSS custom property on the element:

```html
<div class="dish__art" style="--photo:url('images/crackling-pork-banh-mi.jpg')">
```

Same pattern on `.hero-card__art` (hero dish card) and `.panel-img` (story panel).
The gradient stays underneath as a fallback, so a missing file never leaves a blank box.

## Before this goes public

- [ ] **Instagram link** is a placeholder (`https://www.instagram.com/`) — search for
      `TODO` in `index.html` and swap in the real profile, or remove the button.
- [ ] **Trading hours** are listed as Mon–Fri 9 am – 6 pm. Sources conflicted
      (Google said "opens 9 am Fri", the delivery listing said "Fri 9:30 am – 5:45 pm"),
      and only Friday was ever explicitly stated. Confirm the full week with the owner.
      Hours appear in two places: the Visit card and the JSON-LD block.
- [ ] **Canonical URL** points at the GitHub Pages address. Update it, plus the two
      `og:`/`twitter:` URL tags, if this moves to a custom domain.
- [ ] Add real photography (see above).

## Content sources

Menu items, prices, "% liked" figures, review quotes and service details are taken from the
business's public Google Business Profile and delivery listing. Rating shown is 4.9 from 201
Google reviews.
