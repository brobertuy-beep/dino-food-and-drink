(function(){
  var featuredEl = document.getElementById('featured-menu');
  var listEl = document.getElementById('full-menu-list');
  var errorHtml = '<p class="menu-error">Our menu is being updated. Call <a href="tel:0468595689">0468 595 689</a> for today\'s prices.</p>';
  var esc = function(s){ return String(s == null ? '' : s).replace(/[&<>"]/g, function(c){ return {'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;'}[c]; }); };
  var tints = ['#E8873C,#C4342C', '#D8A33F,#8A5A1E', '#3E8C68,#234F3C', '#C4342C,#7C221C', '#E8873C,#B5641F', '#5A3A26,#241A14'];

  // Reveal on scroll. Reusable, because menu content from the Google Sheet arrives after page load.
  var noMotion = !('IntersectionObserver' in window) || window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var io = noMotion ? null : new IntersectionObserver(function(entries){
    entries.forEach(function(entry){
      if (entry.isIntersecting){
        var el = entry.target;
        var delay = (Array.prototype.indexOf.call(el.parentNode.children, el) % 4) * 70;
        setTimeout(function(){ el.classList.add('is-in'); }, delay);
        io.unobserve(el);
      }
    });
  }, {rootMargin:'0px 0px -8% 0px', threshold:0.08});
  function reveal(root){
    var els = root.querySelectorAll('.reveal:not(.is-in)');
    els.forEach(function(el){ io ? io.observe(el) : el.classList.add('is-in'); });
    // Safety net: if anything blocks the observer, show everything anyway.
    setTimeout(function(){ els.forEach(function(el){ el.classList.add('is-in'); }); }, 2500);
  }

  // ---------- Menu rendering (same shape whether data comes from the sheet or menu.js)
  function renderMenu(M){
    if (!M || !M.featured || !M.sections){ featuredEl.innerHTML = errorHtml; listEl.innerHTML = ''; return false; }
    try {
      featuredEl.innerHTML = M.featured.map(function(d, i){
        var main = d.store
          ? '<span class="dish__price">' + esc(d.store) + '</span><span class="dish__where">' + esc(d.serve ? d.serve + ', in store' : 'in store') + '</span>'
          : '<span class="dish__price">' + esc(d.uber) + '</span><span class="dish__where">on Uber Eats</span>';
        var side = d.storeOnly ? '<span class="tag">In store only</span>'
          : (d.store && d.uber) ? '<span class="dish__alt"><b>' + esc(d.uber) + '</b> on Uber Eats</span>' : '';
        return '<article class="dish reveal">' +
          '<div class="dish__art" style="--tint:linear-gradient(140deg,' + tints[i % tints.length] + ')">' +
            (d.badge ? '<span class="dish__badge">' + esc(d.badge) + '</span>' : '') + '</div>' +
          '<div class="dish__body">' +
            '<h3 class="h3 dish__name">' + esc(d.name) + '</h3>' +
            '<p class="dish__desc">' + esc(d.desc) + '</p>' +
            (d.liked ? '<p class="dish__liked">' + esc(d.liked) + '</p>' : '') +
            '<div class="dish__foot"><div class="dish__pricing">' + main + '</div>' + side + '</div>' +
          '</div></article>';
      }).join('');

      listEl.innerHTML = M.sections.map(function(s, i){
        return '<div class="mcat reveal' + (s.tag ? ' mcat--feature' : '') + '">' +
          '<h4 class="mcat__title">' + esc(s.title) + (s.tag ? '<span class="tag">' + esc(s.tag) + '</span>' : '') + '</h4>' +
          (s.note ? '<p class="mcat__note">' + esc(s.note) + '</p>' : '') +
          s.items.map(function(it){
            return '<div class="mi"><span class="mi__name">' + esc(it.name) +
              (it.vi ? '<span class="mi__vi">' + esc(it.vi) + '</span>' : '') +
              (it.desc ? '<span class="mi__desc">' + esc(it.desc) + '</span>' : '') + '</span>' +
              '<span class="mi__price">' + [].concat(it.price).map(function(p){ return '<span>' + esc(p) + '</span>'; }).join('') + '</span></div>';
          }).join('') + '</div>';
      }).join('');

      var hero = M.featured[0];
      if (hero && hero.store){
        document.getElementById('hero-dish-name').textContent = hero.name;
        document.getElementById('hero-dish-price').textContent = hero.store;
        document.getElementById('hero-dish-note').textContent = 'in store' + (hero.uber ? ' · ' + hero.uber + ' on Uber Eats' : '');
      }
    } catch (e) {
      featuredEl.innerHTML = errorHtml; listEl.innerHTML = '';
      return false;
    }
    reveal(featuredEl); reveal(listEl);
    return true;
  }

  // ---------- Google Sheet (published to web as CSV)
  function parseCSV(text){
    var rows = [], row = [], field = '', inQuotes = false, c;
    text = String(text).replace(/^﻿/, '');
    for (var i = 0; i < text.length; i++){
      c = text[i];
      if (inQuotes){
        if (c === '"'){ if (text[i + 1] === '"'){ field += '"'; i++; } else inQuotes = false; }
        else field += c;
      } else if (c === '"') inQuotes = true;
      else if (c === ','){ row.push(field); field = ''; }
      else if (c === '\n' || c === '\r'){
        if (c === '\r' && text[i + 1] === '\n') i++;
        row.push(field); rows.push(row); row = []; field = '';
      } else field += c;
    }
    if (field !== '' || row.length){ row.push(field); rows.push(row); }
    return rows;
  }

  function sheetToMenu(rows){
    var head = (rows[0] || []).map(function(h){ return String(h).trim().toLowerCase(); });
    // A sheet that is not published returns a Google sign-in page instead of CSV; this catches it.
    if (head.indexOf('dish') < 0 || head.indexOf('price') < 0) throw new Error('Sheet is missing the Dish or Price column');
    var get = function(r, name){ var i = head.indexOf(name); return i < 0 ? '' : String(r[i] == null ? '' : r[i]).trim(); };
    var isNo = function(v){ return /^(no|n|hide|hidden|false|0)$/i.test(v); };
    var sections = [], byTitle = {}, featured = [];

    rows.slice(1).forEach(function(r, rowIdx){
      var name = get(r, 'dish');
      if (!name || isNo(get(r, 'show'))) return;
      var prices = [get(r, 'price'), get(r, 'price 2')].filter(Boolean);
      var uber = get(r, 'uber eats price');
      var title = get(r, 'section');

      if (title){
        var key = title.toLowerCase(), s = byTitle[key];
        if (!s){ s = byTitle[key] = { title: title, items: [] }; sections.push(s); }
        if (!s.note && get(r, 'section note')) s.note = get(r, 'section note');
        if (!s.tag && get(r, 'section tag')) s.tag = get(r, 'section tag');
        if (prices.length) s.items.push({ name: name, vi: get(r, 'vietnamese name'), desc: get(r, 'description'), price: prices.length > 1 ? prices : prices[0] });
      }

      var feat = get(r, 'featured');
      if (feat && !isNo(feat) && (prices.length || uber)){
        var pos = parseFloat(feat);
        // Cards show the largest serve; "3 for $12" becomes "$12" with "for 3", matching menu.js cards
        var cardPrice = prices[prices.length - 1] || '', serve = '';
        var sized = /^(\d+)\s+for\s+(\$\s?[\d.,]+)$/i.exec(cardPrice);
        if (sized){ cardPrice = sized[2].replace(/\s/g, ''); serve = 'for ' + sized[1]; }
        featured.push({
          order: isNaN(pos) ? 1e6 : pos, row: rowIdx, name: name,
          badge: get(r, 'card label'), desc: get(r, 'card description') || get(r, 'description'),
          store: cardPrice, serve: serve, uber: uber, liked: get(r, 'card note'),
          storeOnly: !!(prices.length && !uber)
        });
      }
    });

    featured.sort(function(a, b){ return (a.order - b.order) || (a.row - b.row); });
    sections = sections.filter(function(s){ return s.items.length; });
    if (!sections.length && !featured.length) throw new Error('Sheet has no dishes');
    return { featured: featured.slice(0, 6), sections: sections };
  }

  function load(url){
    if (!url){ renderMenu(window.DINO_MENU); return Promise.resolve('menu.js'); }
    featuredEl.innerHTML = '<p class="menu-error">Loading menu</p>';
    listEl.innerHTML = '';
    var ctrl = window.AbortController ? new AbortController() : null;
    var timer = ctrl ? setTimeout(function(){ ctrl.abort(); }, 8000) : null;
    return fetch(url, { cache: 'no-store', signal: ctrl ? ctrl.signal : undefined })
      .then(function(res){ if (!res.ok) throw new Error('HTTP ' + res.status); return res.text(); })
      .then(function(text){
        clearTimeout(timer);
        if (!renderMenu(sheetToMenu(parseCSV(text)))) throw new Error('Could not render sheet');
        return 'sheet';
      })
      .catch(function(err){
        clearTimeout(timer);
        if (window.console) console.warn('Menu: Google Sheet unavailable, showing menu.js instead.', err);
        renderMenu(window.DINO_MENU);
        return 'menu.js (fallback)';
      });
  }
  window.DinoMenu = { load: load, parseCSV: parseCSV, sheetToMenu: sheetToMenu };

  // Sticky header shadow
  var header = document.querySelector('.site-header');
  var onScroll = function(){ header.classList.toggle('is-stuck', window.scrollY > 8); };
  onScroll();
  window.addEventListener('scroll', onScroll, {passive:true});

  // Current year
  var y = document.getElementById('year');
  if (y) y.textContent = new Date().getFullYear();

  load(window.DINO_SHEET_URL);
  reveal(document);
})();
