# Managing theme menus

The Winter theme provides two WordPress menu locations:

- **Primary Menu** — the header navigation.
- **Footer Menu** — the footer's Company links column.

## Create the header menu

1. In WordPress admin, go to **Appearance → Menus**. If your WordPress version does not show that screen, use **Appearance → Customize → Menus**.
2. Create a menu named **Main Menu**.
3. Add these pages in this order:
   - Home
   - About us
   - Services
     - Web Design
     - Website Maintenance
     - Website Redesign
   - Web Hosting
   - Our clients
   - Contact
4. Drag **Web Design**, **Website Maintenance**, and **Website Redesign** beneath **Services** so they are indented as child items. This creates the Services dropdown.
5. Under **Menu Settings** or **Display location**, assign the menu to **Primary Menu**.
6. Save the menu.

## Create the footer menu

1. Create another menu, for example **Footer Menu**.
2. Add the links you want in the footer Company column, such as Home, About us, Our clients, and Contact us.
3. Assign it to **Footer Menu** and save.

Until a menu is assigned, the theme preserves the existing built-in header and footer links as a safe fallback.

## 3-Level Menu Support

The Primary Menu supports three levels. For example:

- WordPress Plugins
  - Admin Watch
  - SocialFeed
    - Terms
    - Privacy
    - Support

In **Appearance → Menus**, add **WordPress Plugins** (or Plugins) to the Primary Menu, then add **Admin Watch** and **SocialFeed** as child items. Drag **Terms**, **Privacy**, and **Support** slightly farther to the right beneath SocialFeed if needed, and add **Resources** as a top-level item. Assign the menu to **Primary Menu** and save it. On desktop, the third level opens as a flyout; on mobile, it appears as an indented list.

## Desktop header layout

At desktop widths above 1280px, the header uses a dedicated 1280px maximum layout track so the existing-size logo, WordPress-managed top-level links and **Get a quote** CTA are balanced without increasing header height. Top-level menu items use a consistent 24px gap; the CTA is separated from Contact by the shared 26px header gap. Dropdown labels use a small CSS chevron, not a text `v`.

Between 1101px and 1280px, the header progressively reduces the shared gap to 24px and the menu gap to 16px so it remains on one line with no overlap or horizontal scrolling. At 1100px and below, preserve the accessible hamburger/menu-panel implementation rather than trying to compress desktop navigation further. Do not hardcode links: menu content must remain WordPress-managed.

## 2026-10-19 mobile interaction update

Up to 1100px, the menu starts closed and each submenu starts collapsed. Separate accessible buttons toggle sibling accordions at each hierarchy level; parent links continue to navigate. The panel scrolls within the available dynamic viewport height. See [mobile navigation standards](mobile-responsiveness.md) for keyboard, close, safe-area and testing requirements. This supersedes the earlier always-visible mobile indented-list behaviour and 980px header breakpoint above.
