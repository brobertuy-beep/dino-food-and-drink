<?php
/**
 * Dino Food & Drink: single page theme.
 * Editable values live in Appearance > Customize > Dino Food & Drink.
 */
$dino_phone        = dino_opt( 'dino_phone', '0468 595 689' );
$dino_phone_digits = preg_replace( '/\\s+/', '', $dino_phone );
$dino_uber         = dino_opt( 'dino_uber_url', 'https://www.ubereats.com/au/store/dino-food-&-drink/Jf55f-nFShqsC2IZewn_hA' );
$dino_maps         = dino_opt( 'dino_maps_url', 'https://www.google.com/maps/place/Dino+Food+%26+Drink/@-27.4599475,153.0222981,17z' );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dino Food &amp; Drink | Brisbane's Best Banh Mi, Baked Fresh in Spring Hill</title>
<meta name="description" content="A family-run Vietnamese kitchen on Boundary Street, Spring Hill. Baguettes baked on the premises every morning, roast pork with crackle, rice paper rolls and phin-brewed coffee. 4.9★ from 200+ Google reviews.">

<link rel="canonical" href="https://dinofoodanddrink.com.au/">

<link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Crect width='64' height='64' rx='14' fill='%23C4342C'/%3E%3Ctext x='32' y='46' font-family='Georgia,serif' font-size='42' font-weight='bold' fill='%23FBF6EE' text-anchor='middle'%3ED%3C/text%3E%3C/svg%3E">

<!-- Social sharing preview -->
<meta property="og:type" content="restaurant">
<meta property="og:title" content="Dino Food &amp; Drink | Spring Hill, Brisbane">
<meta property="og:description" content="Brisbane's best banh mi, baked fresh in Spring Hill. 4.9★ from 200+ Google reviews. Dine in, takeaway or delivered.">
<meta property="og:url" content="https://dinofoodanddrink.com.au/">
<meta property="og:locale" content="en_AU">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="Dino Food &amp; Drink | Spring Hill, Brisbane">
<meta name="twitter:description" content="Brisbane's best banh mi, baked fresh in Spring Hill. 4.9★ from 200+ Google reviews.">
<meta name="theme-color" content="#17110D">

<script>document.documentElement.className += ' js';</script>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>

<!-- ================= HEADER ================= -->
<header class="site-header" id="top">
  <div class="wrap">
    <nav class="nav" aria-label="Primary">
      <a class="brand" href="#top">
        <span class="brand__mark" aria-hidden="true">D</span>
        <span class="brand__text">
          <span class="brand__name">Dino Food &amp; Drink</span>
          <span class="brand__sub">Spring Hill · Brisbane</span>
        </span>
      </a>

      <div class="nav__links">
        <a href="#menu">Menu</a>
        <a href="#story">Our story</a>
        <a href="#reviews">Reviews</a>
        <a href="#visit">Visit</a>
      </div>

      <div class="nav__cta">
        <a class="btn btn--sm" href="<?php echo esc_url( $dino_uber ); ?>" target="_blank" rel="noopener">Order online</a>
      </div>
    </nav>
  </div>
</header>

<!-- ================= HERO ================= -->
<section class="hero">
  <div class="wrap hero__inner">
    <div>
      <div class="rating-chip">
        <span class="stars" aria-hidden="true">★★★★★</span>
        <b>4.9</b>
        <span>· 201 Google reviews</span>
      </div>

      <h1 class="h-display">Brisbane's best banh mi, <em>baked fresh</em> in Spring Hill.</h1>

      <p class="lede lede--on-dark">
        A tiny family-run kitchen on Boundary Street where the baguettes come out of the oven every
        morning, the pork is roasted for crackle, and the herbs are cut to order. Vietnamese classics
        done properly, from $1 to $20 a person.
      </p>

      <div class="btn-row">
        <a class="btn" href="<?php echo esc_url( $dino_uber ); ?>" target="_blank" rel="noopener">
          Order online
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h13M12 5l7 7-7 7"/></svg>
        </a>
        <a class="btn btn--onDark" href="tel:<?php echo esc_attr( $dino_phone_digits ); ?>">
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2Z"/></svg>
          Call <?php echo esc_html( $dino_phone ); ?>
        </a>
        <a class="btn btn--onDark" href="<?php echo esc_url( $dino_maps ); ?>" target="_blank" rel="noopener">Get directions</a>
      </div>

      <div class="hero__meta">
        <span><i class="dot" aria-hidden="true"></i> Dine in</span>
        <span><i class="dot" aria-hidden="true"></i> Takeaway</span>
        <span><i class="dot" aria-hidden="true"></i> No-contact delivery</span>
        <span><i class="dot" aria-hidden="true"></i> Vegan &amp; vegetarian options</span>
      </div>
    </div>

    <!-- Hero visual. To use a photo: style="--photo:url('images/crackling-pork-banh-mi.jpg')" on .hero-card__art -->
    <div class="hero__visual">
      <article class="hero-card">
        <div class="hero-card__art">
          <span class="hero-card__glyph" aria-hidden="true">Dino</span>
        </div>
        <div class="hero-card__body">
          <span class="hero-card__rank">No. 1 most liked</span>
          <h2 class="hero-card__title" id="hero-dish-name">Roasted Pork Banh Mi</h2>
          <div class="hero-card__row">
            <span class="hero-card__price" id="hero-dish-price">$11.50</span>
            <span class="hero-card__note" id="hero-dish-note">in store · $15.80 on Uber Eats</span>
          </div>
        </div>
      </article>

      <div class="hero-quote">
        <p>“Best banh mi in Brisbane. Tried the crispy pork and it was just perfect.”</p>
        <footer>La Queen · Google review</footer>
      </div>
    </div>
  </div>
</section>

<!-- ================= STATS ================= -->
<section class="stats" aria-label="At a glance">
  <div class="wrap">
    <div class="stats__grid">
      <div class="stat reveal"><b>4.9★</b><span>201 Google reviews</span></div>
      <div class="stat reveal"><b>Daily</b><span>Baguettes baked on site</span></div>
      <div class="stat reveal"><b>$1 to $20</b><span>Per person</span></div>
      <div class="stat reveal"><b>2 min</b><span>From the Brisbane CBD</span></div>
    </div>
  </div>
</section>

<!-- ================= MENU ================= -->
<section class="section" id="menu">
  <div class="wrap">
    <div class="sec-head sec-head--split reveal">
      <div>
        <p class="eyebrow">The favourites</p>
        <h2 class="h1">The dishes people drive across town for.</h2>
        <p class="lede" style="margin-top:20px;">
          Banh mi, rice paper rolls, broken rice, noodle salads and now pho. Counter prices are
          shown first, with the Uber Eats price alongside.
        </p>
      </div>
      <a class="btn btn--ghost" href="#full-menu">See the full menu</a>
    </div>

    <!-- Featured cards and the full menu are built from menu.js. Edit prices there, not here. -->
    <div class="menu-grid" id="featured-menu">
      <noscript><p class="menu-error">Call <a href="tel:<?php echo esc_attr( $dino_phone_digits ); ?>"><?php echo esc_html( $dino_phone ); ?></a> for our menu and prices.</p></noscript>
    </div>

    <div class="fullmenu" id="full-menu">
      <div class="fullmenu__head reveal">
        <div>
          <p class="eyebrow">Full menu</p>
          <h3 class="h1">Everything we make, at counter prices.</h3>
        </div>
        <p class="lede">
          These are our in-store prices. Uber Eats prices are set separately for delivery.
          Pre-order by phone and your food will be ready to pick up.
        </p>
      </div>

      <div class="fullmenu__grid" id="full-menu-list">
        <noscript><p class="menu-error">Call <a href="tel:<?php echo esc_attr( $dino_phone_digits ); ?>"><?php echo esc_html( $dino_phone ); ?></a> for our full menu and prices.</p></noscript>
      </div>

      <div class="menu-foot reveal">
        <p><b>Skip the delivery fees.</b> Call ahead on <?php echo esc_html( $dino_phone ); ?> and pick up at the counter, or order delivery through Uber Eats.</p>
        <div class="btn-row">
          <a class="btn" href="tel:<?php echo esc_attr( $dino_phone_digits ); ?>">Pre-order by phone</a>
          <a class="btn btn--ghost" href="<?php echo esc_url( $dino_uber ); ?>" target="_blank" rel="noopener">Delivery on Uber Eats</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ================= STORY ================= -->
<section class="section story" id="story">
  <div class="wrap story__grid">
    <div class="story__copy reveal">
      <p class="eyebrow">Our story</p>
      <h2 class="h1">A mum, her son, and a small family kitchen with no shortcuts.</h2>
      <div style="margin-top:24px;">
        <p class="lede">
          Dino Food &amp; Drink is a small family restaurant at Shop 2, 466 Boundary Street, run by a
          mum and her son who work the counter themselves. That is why the reviews mention the
          welcome almost as often as the food.
        </p>
        <p class="lede">
          The baguettes are baked in-house so the crust shatters and the crumb stays light. Pork is
          roasted for crackling, chicken is marinated in lemongrass overnight, and the pickles, herbs
          and rolls are cut fresh through the day. Nothing sits.
        </p>
        <p class="lede">
          Eat in at the shaded outdoor tables, grab a roll on the way into the city, or have it
          delivered. Either way you get the same plate we'd serve family.
        </p>
      </div>

      <ul class="story__list">
        <li><span class="tick" aria-hidden="true">✓</span> Baguettes baked on the premises every morning</li>
        <li><span class="tick" aria-hidden="true">✓</span> Vegan and vegetarian versions of most dishes</li>
        <li><span class="tick" aria-hidden="true">✓</span> Outdoor seating, wheelchair-accessible entrance</li>
        <li><span class="tick" aria-hidden="true">✓</span> Card, debit and mobile payments accepted</li>
      </ul>
    </div>

    <!-- Owner / shopfront photo slot: style="--photo:url('images/shopfront.jpg')" on .panel-img -->
    <div class="story__panel reveal">
      <div class="panel-img">
        <blockquote class="panel-quote">
          “They make their own banh mi rolls on premises. Best I've ever had. Perfect crispy
          outside, fluffy inside.”
          <footer>David Cole · Google Local Guide</footer>
        </blockquote>
      </div>
      <div class="panel-badge">
        <b>2 yrs</b>
        <span>Serving Spring Hill</span>
      </div>
    </div>
  </div>
</section>

<!-- ================= REVIEWS ================= -->
<section class="section reviews" id="reviews">
  <div class="wrap">
    <div class="sec-head reveal">
      <p class="eyebrow">Loved locally</p>
      <h2 class="h1">4.9 stars from more than 200 reviews.</h2>
      <p class="lede" style="margin-top:20px;">
        People come from the Gold Coast for the banh mi. Here's what they say when they get back.
      </p>
    </div>

    <div class="reviews__grid">
      <article class="review reveal">
        <div class="stars" aria-label="5 out of 5 stars">★★★★★</div>
        <blockquote>“Outstanding authentic Vietnamese. Best I have had in Brisbane in a long while. Worth travelling for. Best pork spring rolls in Brisbane.”</blockquote>
        <footer>
          <span class="avatar" aria-hidden="true">MS</span>
          <span><cite>Michael Stone</cite><small>Local Guide · 399 reviews</small></span>
        </footer>
      </article>

      <article class="review reveal">
        <div class="stars" aria-label="5 out of 5 stars">★★★★★</div>
        <blockquote>“Unexpectedly amazing. They make their own banh mi rolls on premises. Best I've ever had. Got addicted to this place.”</blockquote>
        <footer>
          <span class="avatar avatar--b" aria-hidden="true">DC</span>
          <span><cite>David Cole</cite><small>Local Guide · 11 reviews</small></span>
        </footer>
      </article>

      <article class="review reveal">
        <div class="stars" aria-label="5 out of 5 stars">★★★★★</div>
        <blockquote>“Absolutely fantastic crispy pork banh mi. Perfect ratios of fillings and sauces. I will absolutely be coming back. 10/10.”</blockquote>
        <footer>
          <span class="avatar avatar--c" aria-hidden="true">PS</span>
          <span><cite>Peter Sherwood</cite><small>Google review</small></span>
        </footer>
      </article>

      <article class="review reveal">
        <div class="stars" aria-label="5 out of 5 stars">★★★★★</div>
        <blockquote>“The Rare Beef Pho was top tier. A very generous serving with a flavourful broth, at a reasonable price.”</blockquote>
        <footer>
          <span class="avatar avatar--d" aria-hidden="true">BL</span>
          <span><cite>Ben Lee</cite><small>Local Guide · 27 reviews</small></span>
        </footer>
      </article>

      <article class="review reveal">
        <div class="stars" aria-label="5 out of 5 stars">★★★★★</div>
        <blockquote>“A taste of Vietnam in Brisbane! Nice staff and such a delicious banh mi! The bread was really fresh and flaky.”</blockquote>
        <footer>
          <span class="avatar avatar--b" aria-hidden="true">PG</span>
          <span><cite>Paulina Grabowska</cite><small>Local Guide · 56 reviews</small></span>
        </footer>
      </article>

      <article class="review reveal">
        <div class="stars" aria-label="5 out of 5 stars">★★★★★</div>
        <blockquote>“Such a cosy, comforting and affordable place for authentic Vietnamese food. Their vegan banh mi is my favourite in all of Brisbane!”</blockquote>
        <footer>
          <span class="avatar" aria-hidden="true">EC</span>
          <span><cite>Ella Carlyle</cite><small>Local Guide · 27 reviews</small></span>
        </footer>
      </article>
    </div>

    <div class="reviews__foot reveal">
      <p>Rated 4.9 by 201 diners on Google.</p>
      <a class="btn btn--ghost" href="<?php echo esc_url( $dino_maps ); ?>" target="_blank" rel="noopener">Read all reviews</a>
    </div>
  </div>
</section>

<!-- ================= GOOD TO KNOW ================= -->
<section class="section know">
  <div class="wrap">
    <div class="sec-head reveal">
      <p class="eyebrow">Good to know</p>
      <h2 class="h1">Everything before you walk in.</h2>
    </div>
    <div class="know__grid">
      <div class="know__item reveal">
        <h3>Service</h3>
        <ul><li>Dine in</li><li>Takeaway</li><li>No-contact delivery</li><li>Outdoor seating</li></ul>
      </div>
      <div class="know__item reveal">
        <h3>Offerings</h3>
        <ul><li>Coffee</li><li>Quick bite &amp; small plates</li><li>Vegan options</li><li>Vegetarian options</li></ul>
      </div>
      <div class="know__item reveal">
        <h3>Access &amp; parking</h3>
        <ul><li>Wheelchair-accessible entrance</li><li>Paid street parking</li><li>Plenty of parking nearby</li></ul>
      </div>
      <div class="know__item reveal">
        <h3>Payments</h3>
        <ul><li>Credit cards</li><li>Debit cards</li><li>NFC mobile payments</li></ul>
      </div>
    </div>
  </div>
</section>

<!-- ================= VISIT / CTA ================= -->
<section class="section visit" id="visit">
  <div class="wrap visit__grid">
    <div class="reveal">
      <p class="eyebrow eyebrow--light">Visit us</p>
      <h2 class="h1">Hungry now? We're two minutes from the CBD.</h2>
      <p class="lede lede--on-dark" style="margin-top:22px;">
        Order ahead for pickup, get it delivered across Brisbane, or just walk in and say hello.
        New delivery customers pay $0 delivery.
      </p>

      <div class="btn-row">
        <a class="btn" href="<?php echo esc_url( $dino_uber ); ?>" target="_blank" rel="noopener">
          Order online
          <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.4" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M5 12h13M12 5l7 7-7 7"/></svg>
        </a>
        <a class="btn btn--onDark" href="tel:<?php echo esc_attr( $dino_phone_digits ); ?>">Call <?php echo esc_html( $dino_phone ); ?></a>
        <a class="btn btn--onDark" href="<?php echo esc_url( $dino_maps ); ?>" target="_blank" rel="noopener">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
          Get directions
        </a>
      </div>
    </div>

    <div class="info-card reveal">
      <div class="info-row">
        <span class="info-ico" aria-hidden="true">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
        </span>
        <div>
          <h3>Address</h3>
          <a href="<?php echo esc_url( $dino_maps ); ?>" target="_blank" rel="noopener">Shop 2, 466 Boundary Street<br>Spring Hill, QLD 4000</a>
        </div>
      </div>

      <div class="info-row">
        <span class="info-ico" aria-hidden="true">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.2 2"/></svg>
        </span>
        <div>
          <h3>Hours</h3>
          <p>Monday to Friday · 9 am to 6 pm<br>Saturday · 10 am to 4 pm</p>
          <small>Closed Sundays</small>
        </div>
      </div>

      <div class="info-row">
        <span class="info-ico" aria-hidden="true">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.9v3a2 2 0 0 1-2.2 2 19.8 19.8 0 0 1-8.6-3.1 19.5 19.5 0 0 1-6-6A19.8 19.8 0 0 1 2.1 4.2 2 2 0 0 1 4.1 2h3a2 2 0 0 1 2 1.7c.1 1 .4 1.9.7 2.8a2 2 0 0 1-.5 2.1L8.1 9.9a16 16 0 0 0 6 6l1.3-1.3a2 2 0 0 1 2.1-.4c.9.3 1.8.6 2.8.7a2 2 0 0 1 1.7 2Z"/></svg>
        </span>
        <div>
          <h3>Phone</h3>
          <a href="tel:<?php echo esc_attr( $dino_phone_digits ); ?>"><?php echo esc_html( $dino_phone ); ?></a>
        </div>
      </div>

      <div class="info-row">
        <span class="info-ico" aria-hidden="true">
          <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 20V9.5L12 4l8 5.5V20"/><path d="M9 20v-6h6v6"/></svg>
        </span>
        <div>
          <h3>How to order</h3>
          <p>Dine in · Takeaway · Delivery</p>
          <small>Group orders welcome · $1 to $20 per person</small>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ================= FOOTER ================= -->
<footer class="site-footer">
  <div class="wrap">
    <div class="footer__top">
      <a class="brand" href="#top">
        <span class="brand__mark" aria-hidden="true">D</span>
        <span class="brand__text">
          <span class="brand__name">Dino Food &amp; Drink</span>
          <span class="brand__sub">Vietnamese · Spring Hill</span>
        </span>
      </a>
      <nav class="footer__links" aria-label="Footer">
        <a href="#menu">Menu</a>
        <a href="#story">Our story</a>
        <a href="#reviews">Reviews</a>
        <a href="#visit">Visit</a>
        <a href="tel:<?php echo esc_attr( $dino_phone_digits ); ?>">Call</a>
      </nav>
    </div>
    <div class="footer__bottom">
      <span>Shop 2, 466 Boundary St, Spring Hill QLD 4000 · <a href="tel:<?php echo esc_attr( $dino_phone_digits ); ?>"><?php echo esc_html( $dino_phone ); ?></a></span>
      <span>© <span id="year">2026</span> Dino Food &amp; Drink. All rights reserved.</span>
    </div>
  </div>
</footer>

<!-- Sticky mobile action bar -->
<div class="mobile-bar" role="group" aria-label="Quick actions">
  <a class="btn" href="<?php echo esc_url( $dino_uber ); ?>" target="_blank" rel="noopener">Order online</a>
  <a class="btn btn--light" href="tel:<?php echo esc_attr( $dino_phone_digits ); ?>">Call</a>
</div>

<script type="application/ld+json">
{
  "@context":"https://schema.org",
  "@type":"Restaurant",
  "name":"Dino Food & Drink",
  "url":"https://dinofoodanddrink.com.au/",
  "servesCuisine":"Vietnamese",
  "priceRange":"$1-20",
  "telephone":"+61468595689",
  "address":{
    "@type":"PostalAddress",
    "streetAddress":"Shop 2, 466 Boundary Street",
    "addressLocality":"Spring Hill",
    "addressRegion":"QLD",
    "postalCode":"4000",
    "addressCountry":"AU"
  },
  "geo":{"@type":"GeoCoordinates","latitude":-27.4606806,"longitude":153.0223195},
  "aggregateRating":{"@type":"AggregateRating","ratingValue":"4.9","reviewCount":"201","bestRating":"5"},
  "openingHoursSpecification":[{
    "@type":"OpeningHoursSpecification",
    "dayOfWeek":["Monday","Tuesday","Wednesday","Thursday","Friday"],
    "opens":"09:00","closes":"18:00"
  },{
    "@type":"OpeningHoursSpecification",
    "dayOfWeek":["Saturday"],
    "opens":"10:00","closes":"16:00"
  }],
  "hasMenu":"https://www.ubereats.com/au/store/dino-food-%26-drink/Jf55f-nFShqsC2IZewn_hA",
  "acceptsReservations":"False"
}
</script>

<?php wp_footer(); ?>
</body>
</html>
