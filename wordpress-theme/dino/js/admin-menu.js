/* Menu & Prices editor. Builds the editing screen from window.DINO_MENU_ADMIN and, on
   Save, sends the whole menu as one JSON field. The server cleans every value again. */
(function () {
  'use strict';

  var root = document.getElementById('dino-menu-editor');
  var form = document.getElementById('dino-menu-form');
  var jsonField = document.getElementById('dino-menu-json');
  var statusEl = document.getElementById('dino-save-status');
  var saveBtn = document.getElementById('dino-save');
  var start = (window.DINO_MENU_ADMIN && window.DINO_MENU_ADMIN.sections) || [];
  if (!root || !form || !jsonField) return;

  var ITEM_DEFAULTS = { dish: '', vi: '', desc: '', price: '', price2: '', uber: '', show: true, featured: '', card_label: '', card_desc: '', card_note: '' };
  var FEATURED = [['', 'Not featured'], ['1', '1: first card, and the big card at the top'], ['2', '2'], ['3', '3'], ['4', '4'], ['5', '5'], ['6', '6']];
  var uid = 0;
  var dirty = false;

  /* ---------- tiny DOM helper */
  function h(tag, attrs, kids) {
    var n = document.createElement(tag);
    if (attrs) Object.keys(attrs).forEach(function (k) {
      var v = attrs[k];
      if (v === null || v === undefined || v === false) return;
      if (k === 'text') n.textContent = v;
      else if (k === 'className') n.className = v;
      else n.setAttribute(k, v === true ? '' : v);
    });
    (kids || []).forEach(function (c) { if (c) n.appendChild(typeof c === 'string' ? document.createTextNode(c) : c); });
    return n;
  }
  function val(scope, name) {
    var el = scope.querySelector('[data-field="' + name + '"]');
    return el ? String(el.value || '').trim() : '';
  }
  function btn(text, label, action, extra) {
    return h('button', { type: 'button', className: 'button dino-btn' + (extra ? ' ' + extra : ''), 'data-action': action, 'aria-label': label, title: label, text: text });
  }
  function field(label, name, value, opts) {
    opts = opts || {};
    var id = 'dino-f' + (++uid);
    var input = opts.options
      ? h('select', { id: id, 'data-field': name }, opts.options.map(function (o) {
          return h('option', { value: o[0], selected: String(value || '') === o[0] ? 'selected' : null, text: o[1] });
        }))
      : h('input', { id: id, type: 'text', 'data-field': name, value: value || '', placeholder: opts.placeholder || null, maxlength: String(opts.max || 200), autocomplete: 'off' });
    return h('div', { className: 'dino-field dino-field--' + name }, [
      h('label', { 'for': id, text: label }),
      input,
      opts.help ? h('p', { className: 'dino-help', text: opts.help }) : null
    ]);
  }

  /* ---------- building blocks */
  function itemNode(item) {
    item = Object.assign({}, ITEM_DEFAULTS, item || {});
    var showId = 'dino-f' + (++uid);
    var show = h('input', { type: 'checkbox', id: showId, 'data-field': 'show', checked: item.show ? 'checked' : null });
    var node = h('div', { className: 'dino-item' + (item.show ? '' : ' is-hidden'), 'data-item': '' }, [
      h('div', { className: 'dino-item__main' }, [
        field('Dish', 'dish', item.dish, { max: 120 }),
        field('Price', 'price', item.price, { placeholder: 'e.g. $17', max: 40 }),
        field('Second price', 'price2', item.price2, { placeholder: 'Optional, e.g. 3 for $12', max: 40 }),
        h('div', { className: 'dino-field dino-field--show' }, [
          h('label', { 'for': showId, className: 'dino-toggle' }, [show, h('span', { text: 'Show on website' })])
        ]),
        h('div', { className: 'dino-item__actions' }, [
          btn('↑', 'Move this dish up', 'item-up'),
          btn('↓', 'Move this dish down', 'item-down'),
          btn('Remove', 'Remove this dish', 'item-remove', 'is-danger')
        ])
      ]),
      h('details', { className: 'dino-more' }, [
        h('summary', { text: 'More options' }),
        h('div', { className: 'dino-more__grid' }, [
          field('Vietnamese name', 'vi', item.vi, { max: 120 }),
          field('Short description', 'desc', item.desc, { max: 200 }),
          field('Uber Eats price', 'uber', item.uber, { placeholder: 'e.g. $15.80', max: 40, help: 'Shown on the featured cards only.' }),
          field('Featured card', 'featured', item.featured, { options: FEATURED, help: 'Puts this dish in the picture cards at the top of the menu.' }),
          field('Card badge', 'card_label', item.card_label, { placeholder: 'e.g. No. 1 most liked', max: 40 }),
          field('Card description', 'card_desc', item.card_desc, { max: 300 }),
          field('Card note', 'card_note', item.card_note, { placeholder: 'e.g. 93% liked on Uber Eats (31)', max: 80 })
        ])
      ])
    ]);
    show.addEventListener('change', function () { node.classList.toggle('is-hidden', !show.checked); });
    return node;
  }

  function sectionNode(section) {
    section = section || {};
    return h('section', { className: 'dino-section', 'data-section': '' }, [
      h('div', { className: 'dino-section__head' }, [
        field('Section heading', 'title', section.title || '', { max: 80 }),
        h('span', { className: 'dino-count' }),
        h('div', { className: 'dino-section__actions' }, [
          btn('↑', 'Move this section up', 'section-up'),
          btn('↓', 'Move this section down', 'section-down'),
          btn('Remove section', 'Remove this section', 'section-remove', 'is-danger')
        ])
      ]),
      h('details', { className: 'dino-more dino-more--section' }, [
        h('summary', { text: 'Heading options' }),
        h('div', { className: 'dino-more__grid' }, [
          field('Note under the heading', 'note', section.note || '', { max: 160, placeholder: 'e.g. Rolls baked on the premises every morning.' }),
          field('Small red tag', 'tag', section.tag || '', { max: 40, placeholder: 'e.g. New, in store only' })
        ])
      ]),
      h('div', { className: 'dino-items' }, (section.items || []).map(itemNode)),
      h('div', { className: 'dino-section__foot' }, [btn('+ Add a dish to this section', 'Add a dish to this section', 'item-add', 'button-secondary')])
    ]);
  }

  /* ---------- the screen */
  var errorBox = h('div', { className: 'notice notice-error dino-errors', role: 'alert', hidden: true });
  var search = h('input', { type: 'search', id: 'dino-search', className: 'regular-text', placeholder: 'Type part of a dish name, e.g. pho', autocomplete: 'off' });
  var sectionsWrap = h('div', { className: 'dino-sections' }, start.map(sectionNode));

  root.textContent = '';
  root.appendChild(errorBox);
  root.appendChild(h('div', { className: 'dino-toolbar' }, [h('label', { 'for': 'dino-search', text: 'Find a dish' }), search]));
  root.appendChild(sectionsWrap);
  root.appendChild(h('p', { className: 'dino-add-section' }, [btn('+ Add a new section', 'Add a new section', 'section-add', 'button-secondary')]));

  function updateCounts() {
    sectionsWrap.querySelectorAll('[data-section]').forEach(function (sec) {
      var n = sec.querySelectorAll('[data-item]').length;
      sec.querySelector('.dino-count').textContent = n + (n === 1 ? ' dish' : ' dishes');
    });
  }
  function markDirty() {
    if (dirty) return;
    dirty = true;
    if (statusEl) { statusEl.textContent = 'Unsaved changes'; statusEl.classList.add('is-dirty'); }
  }
  updateCounts();

  root.addEventListener('input', function (e) { if (e.target !== search) markDirty(); });
  root.addEventListener('change', function (e) { if (e.target !== search) markDirty(); });

  root.addEventListener('click', function (e) {
    var b = e.target.closest('[data-action]');
    if (!b) return;
    var action = b.getAttribute('data-action');
    var item = b.closest('[data-item]');
    var sec = b.closest('[data-section]');
    var name, n, count;

    switch (action) {
      case 'item-up': if (item.previousElementSibling) item.parentNode.insertBefore(item, item.previousElementSibling); break;
      case 'item-down': if (item.nextElementSibling) item.parentNode.insertBefore(item.nextElementSibling, item); break;
      case 'item-remove':
        name = val(item, 'dish') || 'this dish';
        if (!window.confirm('Remove ' + name + ' from the menu?')) return;
        item.parentNode.removeChild(item);
        break;
      case 'item-add':
        n = itemNode({});
        sec.querySelector('.dino-items').appendChild(n);
        n.querySelector('[data-field="dish"]').focus();
        break;
      case 'section-up': if (sec.previousElementSibling) sec.parentNode.insertBefore(sec, sec.previousElementSibling); break;
      case 'section-down': if (sec.nextElementSibling) sec.parentNode.insertBefore(sec.nextElementSibling, sec); break;
      case 'section-remove':
        name = val(sec, 'title') || 'this';
        count = sec.querySelectorAll('[data-item]').length;
        if (!window.confirm(count ? 'Remove the ' + name + ' section and its ' + count + (count === 1 ? ' dish?' : ' dishes?') : 'Remove the ' + name + ' section?')) return;
        sec.parentNode.removeChild(sec);
        break;
      case 'section-add':
        n = sectionNode({ title: '', items: [{}] });
        sectionsWrap.appendChild(n);
        n.querySelector('[data-field="title"]').focus();
        break;
      default: return;
    }
    updateCounts();
    markDirty();
  });

  /* ---------- find a dish */
  search.addEventListener('input', function () {
    var q = search.value.trim().toLowerCase();
    sectionsWrap.querySelectorAll('[data-section]').forEach(function (sec) {
      var titleMatch = !!q && val(sec, 'title').toLowerCase().indexOf(q) >= 0;
      var any = false;
      sec.querySelectorAll('[data-item]').forEach(function (it) {
        var match = !q || titleMatch || (val(it, 'dish') + ' ' + val(it, 'vi')).toLowerCase().indexOf(q) >= 0;
        it.hidden = !match;
        if (match) any = true;
      });
      sec.hidden = !(!q || any || titleMatch);
    });
  });

  /* ---------- read the screen back into data, checking for mistakes */
  function collect() {
    var errors = [], sections = [], featuredSeen = {};
    sectionsWrap.querySelectorAll('[data-section]').forEach(function (sec) {
      var title = val(sec, 'title');
      var items = [];
      sec.querySelectorAll('[data-item]').forEach(function (it) {
        var item = {};
        Object.keys(ITEM_DEFAULTS).forEach(function (k) {
          item[k] = k === 'show' ? it.querySelector('[data-field="show"]').checked : val(it, k);
        });
        var blank = Object.keys(item).every(function (k) { return k === 'show' || !item[k]; });
        if (blank) return; // an added row that was never filled in
        if (!item.dish) {
          errors.push({ msg: 'A dish in ' + (title || 'a section') + ' has no name.', focus: it.querySelector('[data-field="dish"]') });
          return;
        }
        if (item.featured) {
          if (featuredSeen[item.featured]) {
            errors.push({ msg: 'Featured card ' + item.featured + ' is set on both ' + featuredSeen[item.featured] + ' and ' + item.dish + '. Give each featured dish its own number.', focus: it.querySelector('[data-field="featured"]') });
          } else {
            featuredSeen[item.featured] = item.dish;
          }
        }
        items.push(item);
      });
      if (!title) {
        if (items.length) errors.push({ msg: 'A section with dishes in it has no heading.', focus: sec.querySelector('[data-field="title"]') });
        return;
      }
      sections.push({ title: title, note: val(sec, 'note'), tag: val(sec, 'tag'), items: items });
    });
    if (!errors.length && !sections.some(function (s) { return s.items.length; })) {
      errors.push({ msg: 'The menu needs at least one dish.', focus: null });
    }
    return { sections: sections, errors: errors };
  }

  form.addEventListener('submit', function (e) {
    var result = collect();
    if (result.errors.length) {
      e.preventDefault();
      errorBox.textContent = '';
      errorBox.appendChild(h('p', null, [h('strong', { text: 'Not saved yet. Please fix:' })]));
      errorBox.appendChild(h('ul', null, result.errors.map(function (er) { return h('li', { text: er.msg }); })));
      errorBox.hidden = false;
      if (search.value) { search.value = ''; search.dispatchEvent(new Event('input')); }
      var first = result.errors[0].focus;
      if (first) {
        var d = first.closest('details');
        if (d) d.open = true;
        first.focus();
      } else {
        errorBox.scrollIntoView({ block: 'center' });
      }
      return;
    }
    errorBox.hidden = true;
    jsonField.value = JSON.stringify({ sections: result.sections });
    dirty = false;
    if (saveBtn) { saveBtn.disabled = true; saveBtn.textContent = 'Saving'; }
  });

  window.addEventListener('beforeunload', function (e) {
    if (!dirty) return;
    e.preventDefault();
    e.returnValue = '';
  });

  window.DinoMenuAdmin = { collect: collect };
})();
