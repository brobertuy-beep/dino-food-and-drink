/* =====================================================================
   DINO FOOD & DRINK: MENU AND PRICES
   This is the only file you need to change to update the website menu.

   HOW TO CHANGE A PRICE
   1. Find the dish below.
   2. Change the text between the quote marks, for example "$11.50" to "$12".
   3. Keep the quote marks " " and the comma at the end of the line.
   4. Save (on GitHub: click "Commit changes"). The website updates in about a minute.

   HOW TO ADD A DISH
   Copy a whole line that looks like this, paste it underneath, and change the words:
     { name: "Chicken Pho", vi: "Phở Gà", price: "$17" },

   A dish with two sizes uses square brackets, like this:
     price: ["2 for $8.40", "3 for $12"]

   HOW TO HIDE A DISH
   Put two slashes // at the start of its line. Remove them to show it again.

   If the menu ever disappears from the website, a quote mark or comma is
   probably missing. Undo the last change and try again.
   ===================================================================== */

window.DINO_MENU = {

  /* ---------------------------------------------------------------
     FEATURED DISHES: the six picture cards at the top of the menu.
     store = price at the counter      uber = price on Uber Eats
     Leave out "uber" if the dish is not on Uber Eats.
     Leave out "store" if the dish is only sold on Uber Eats.
     --------------------------------------------------------------- */
  featured: [
    { name: "Roasted Pork Banh Mi", badge: "No. 1 most liked",
      desc: "Roast pork and crunchy crackling in a roll baked here this morning, with carrot pickle, cucumber, pâté, egg butter and coriander.",
      store: "$11.50", uber: "$15.80", liked: "93% liked on Uber Eats (31)" },

    { name: "Rare Beef Pho", badge: "New", storeOnly: true,
      desc: "Rare beef and rice noodles in a clear, flavourful broth, with fresh herbs and sauces on the side.",
      store: "$17" },

    { name: "Prawn Rice Paper Rolls", badge: "Made to order",
      desc: "King prawns, lettuce, herbs, pickled carrot, cucumber and rice noodles, with hoisin peanut sauce.",
      store: "$12", serve: "for 3", uber: "$15.80", liked: "100% liked on Uber Eats (7)" },

    { name: "Broken Rice, Grilled Pork & Omelette", badge: "No. 2 most liked",
      desc: "Char-grilled pork chop and an omelette over fragrant broken rice with scallion oil, pickles, fresh lettuce and fish sauce.",
      store: "$16", uber: "$21.60", liked: "100% liked on Uber Eats (3)" },

    { name: "Chicken Rice Paper Rolls", badge: "No. 3 most liked",
      desc: "Grilled chicken rolled with rice noodles, pickled carrot, cucumber and fresh herbs.",
      store: "$12", serve: "for 3", uber: "$14.80", liked: "100% liked on Uber Eats (9)" },

    // CONFIRM: coffee is not on the printed menu, so only the Uber Eats price is shown.
    { name: "Iced Vietnamese Coffee", badge: "House favourite",
      desc: "Robusta beans, phin-brewed the slow way, poured over ice with sweetened condensed milk.",
      uber: "$6.50", liked: "80% liked on Uber Eats (10)" }
  ],

  /* ---------------------------------------------------------------
     FULL MENU: counter prices, grouped by section.
     --------------------------------------------------------------- */
  sections: [
    { title: "Pho", tag: "New, in store only", note: "Not on Uber Eats yet. Dine in or pick up.",
      items: [
        { name: "Rare Beef Pho", vi: "Phở Tái", price: "$17" },
        { name: "Chicken Pho", vi: "Phở Gà", price: "$17" },
        { name: "Rare Beef & Beef Balls Pho", vi: "Phở Tái Bò Viên", price: "$19" },
        { name: "Rare Beef & Brisket Pho", vi: "Phở Tái Nạm", price: "$19" },
        { name: "Combination Pho", vi: "Phở Tái Nạm Bò Viên", desc: "Rare beef, brisket and beef meatballs", price: "$21" }
      ] },

    { title: "Banh Mi", note: "Rolls baked on the premises every morning.",
      items: [
        { name: "Roasted Pork Banh Mi", vi: "Bánh Mì Heo Quay", price: "$11.50" },
        { name: "Lemongrass Beef Banh Mi", vi: "Bánh Mì Thịt Bò", price: "$10.50" },
        { name: "Lemongrass Chicken Banh Mi", vi: "Bánh Mì Gà", price: "$10" },
        { name: "Grilled Pork Banh Mi", vi: "Bánh Mì Thịt Nướng", price: "$10" },
        { name: "Grilled Pork Meatball Banh Mi", vi: "Bánh Mì Nem Nướng", price: "$9.50" },
        { name: "Vegan Banh Mi", vi: "Bánh Mì Chay", price: "$9.50" },
        { name: "Egg Banh Mi", vi: "Bánh Mì Trứng", price: "$9" }
      ] },

    { title: "Rice Paper Rolls",
      items: [
        { name: "Roasted Pork Rice Paper Rolls", vi: "Gỏi Cuốn Heo Quay", price: ["2 for $8.40", "3 for $12"] },
        { name: "Prawn Rice Paper Rolls", vi: "Gỏi Cuốn Tôm", price: ["2 for $8.40", "3 for $12"] },
        { name: "Chicken Rice Paper Rolls", vi: "Gỏi Cuốn Thịt Gà", price: ["2 for $8.40", "3 for $12"] },
        { name: "Beef Rice Paper Rolls", price: ["2 for $8.40", "3 for $12"] },
        { name: "Vegan Rice Paper Rolls", vi: "Gỏi Cuốn Chay", price: ["2 for $8.40", "3 for $12"] }
      ] },

    { title: "Rice Dishes",
      items: [
        { name: "Broken Rice & Grilled Pork", vi: "Cơm Tấm Sườn", price: "$15" },
        { name: "Broken Rice, Grilled Pork & Omelette", vi: "Cơm Tấm Sườn Trứng Ốp La", price: "$16" },
        { name: "Roasted Pork Rice", vi: "Cơm Heo Quay", price: "$17" },
        { name: "Lemongrass Chicken Rice", vi: "Cơm Gà Nướng", price: "$15" },
        { name: "Lemongrass Beef Rice", vi: "Cơm Bò Xào Sả", price: "$16" },
        { name: "Vegan Rice", vi: "Cơm Chay", price: "$15" }
      ] },

    { title: "Rice Noodle Salads",
      items: [
        { name: "Meatball Rice Noodle Salad", vi: "Bún Nem Nướng", price: "$15" },
        { name: "Grilled Pork & Spring Rolls Rice Noodle Salad", vi: "Bún Thịt Nướng Chả Giò", price: "$17" },
        { name: "Roasted Pork Rice Noodle Salad", vi: "Bún Heo Quay", price: "$17" },
        { name: "Lemongrass Chicken Rice Noodle Salad", vi: "Bún Gà Nướng Sả", price: "$15" },
        { name: "Lemongrass Beef Rice Noodle Salad", vi: "Bún Bò Xào Sả", price: "$16" },
        { name: "Vegan Rice Noodle Salad", vi: "Bún Chay", price: "$15" }
      ] },

    { title: "Appetisers",
      items: [
        { name: "Pork Spring Rolls", vi: "Chả Giò Thịt Heo", price: ["3 for $7.60", "4 for $8"] },
        { name: "Vegan Spring Rolls", vi: "Chả Giò Chay", price: ["3 for $7.60", "4 for $8"] },
        { name: "Fried Wontons", vi: "Hoành Thánh Chiên", price: ["4 for $6", "6 for $8"] },
        { name: "Meatball Skewers", vi: "Nem Nướng", price: ["1 for $5", "2 for $9.50"] },
        { name: "Hot Chips", vi: "Khoai Tây Chiên", price: "$5" }
      ] },

    { title: "Extras",
      items: [
        { name: "Extra Meat", price: "$3" },
        { name: "Extra Egg", price: "$2.50" },
        { name: "Extra Spring Roll", price: "$2.50" },
        { name: "Extra Rice", price: "$3" },
        { name: "Extra Pho", price: "$3" }
      ] }
  ]
};
