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
  - SocialFeed
    - Terms
    - Privacy
    - Support

In **Appearance → Menus**, add **SocialFeed** as a child of **WordPress Plugins**. Then drag **Terms**, **Privacy**, and **Support** slightly farther to the right beneath **SocialFeed**. Assign the menu to **Primary Menu** and save it. On desktop, the third level opens as a flyout; on mobile, it appears as an indented list.
