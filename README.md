# PackTrack — Housesit Inventory

Track what you pack when housesitting. Know exactly what you brought and what's still out.

**Live:** https://smartconfigurations.com/nextcloud/remote.php/dav/files/ow9cg/packlist.html

---

## Features

- 📦 Track items by location (Kitchen, Bath, Bedroom, etc.)
- ✈️ Mark items as **IN** (packed) or **OUT** (not yet packed)
- 📷 Attach photos to items (uploaded to Nextcloud via WebDAV)
- 🔐 PIN-protected access
- 📍 Zone management (add, rename, delete locations)
- 🔍 Search and filter
- ☑️ Bulk select and move items between zones
- 📱 PWA-ready — works on mobile

---

## Tech

- Single HTML file, no build step
- Vanilla JS + CSS (no frameworks)
- Data stored in Nextcloud via WebDAV
- PHP proxy (`upload.php`) for image uploads (avoids CORS)

---

## Setup

1. Host `packtrack.html` and `upload.php` on your web server
2. Update credentials in `packtrack.html` (WebDAV user/pass) and `upload.php`
3. Update `WEBDAV_BASE` in the JS to point to your Nextcloud WebDAV images folder

---

## Version

- **v1.0.2** — Fixed image upload (was broken after direct WebDAV PUT approach; now uses PHP proxy for proper CORS support)
- **v1.0.1** — Previous release
- **v1.0.0** — Initial release

---

## WebDAV Storage Structure

```
Nextcloud WebDAV
├── packlist.json          ← item database
├── .packtrack_pin.json    ← PIN code
└── packtrack_images/      ← item photos (itemId.jpg)
```
