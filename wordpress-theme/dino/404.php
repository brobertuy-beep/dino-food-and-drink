<?php
$dino_phone        = dino_opt( 'dino_phone', '0468 595 689' );
$dino_phone_digits = preg_replace( '/\\s+/', '', $dino_phone );
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Page not found | Dino Food &amp; Drink</title>
<meta name="robots" content="noindex">
<link rel="icon" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 64 64'%3E%3Crect width='64' height='64' rx='14' fill='%23C4342C'/%3E%3Ctext x='32' y='46' font-family='Georgia,serif' font-size='42' font-weight='bold' fill='%23FBF6EE' text-anchor='middle'%3ED%3C/text%3E%3C/svg%3E">
<style>
:root{ --ink:#17110D; --cream:#FBF6EE; --chilli:#C4342C; --muted:rgba(251,246,238,.72); }
  *,*::before,*::after{box-sizing:border-box;}
  body{
    margin:0; min-height:100vh;
    display:flex; align-items:center; justify-content:center;
    padding:clamp(24px,6vw,64px);
    background:
      radial-gradient(900px 520px at 85% -10%, rgba(232,135,60,.20), transparent 62%),
      linear-gradient(168deg,#1D140F 0%, var(--ink) 50%, #120C09 100%);
    color:var(--cream);
    font-family:'Inter',-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;
    line-height:1.62; text-align:center;
  }
  .mark{
    width:54px; height:54px; border-radius:15px; margin:0 auto 26px;
    background:linear-gradient(145deg,#C4342C,#E8873C); color:#fff;
    display:grid; place-items:center;
    font-family:'Fraunces',Georgia,serif; font-weight:900; font-size:1.6rem;
  }
  h1{
    font-family:'Fraunces',Georgia,serif; font-weight:900;
    font-size:clamp(2rem,6vw,3.2rem); letter-spacing:-.03em; line-height:1.05; margin:0 0 18px;
  }
  p{color:var(--muted); max-width:46ch; margin:0 auto 32px; font-size:1.03rem;}
  .row{display:flex; flex-wrap:wrap; gap:12px; justify-content:center;}
  a.btn{
    display:inline-flex; align-items:center; justify-content:center;
    min-height:54px; padding:15px 28px; border-radius:999px;
    font-weight:600; text-decoration:none; white-space:nowrap;
    background:var(--chilli); color:#fff; border:1px solid transparent;
    transition:transform .2s ease, background-color .2s ease;
  }
  a.btn:hover{transform:translateY(-2px); background:#A62A23;}
  a.ghost{background:transparent; color:var(--cream); border-color:rgba(251,246,238,.18);}
  a.ghost:hover{background:var(--cream); color:var(--ink);}
  a.btn:focus-visible{outline:3px solid #D8A33F; outline-offset:3px;}
  @media (max-width:380px){ .row a.btn{flex:1 1 100%;} }
</style>
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<main>
    <div class="mark" aria-hidden="true">D</div>
    <h1>We can't find that page.</h1>
    <p>
      The link may be old or mistyped. The food is still here though: banh mi, rice paper rolls,
      pho and Vietnamese coffee on Boundary Street, Spring Hill.
    </p>
    <div class="row">
      <a class="btn" href="/">Back to the menu</a>
      <a class="btn ghost" href="tel:<?php echo esc_attr( $dino_phone_digits ); ?>">Call <?php echo esc_html( $dino_phone ); ?></a>
    </div>
  </main>
<?php wp_footer(); ?>
</body>
</html>
