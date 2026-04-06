# PackTrack

**Never forget what you brought to a housesit. Or where you put it.**

A house-sitter's inventory system built for real life: multiple houses, many trips, stuff scattered across boxes and bags and suitcases. PackTrack tracks every item — where it lives, whether it's packed in or out, and what it looks like.

---

## What It Does

- ✅ **Track items** — name, photo, zone/location, IN/OUT status
- 📍 **Zones** — Kitchen, Bath, Bedroom, Office, Garage, Storage, and any custom zone you add
- 📷 **Photos per item** — click a thumbnail to attach a camera photo, stored in Nextcloud
- 🔐 **PIN protection** — 6-digit passcode shared with partners or clients
- ☁️ **Nextcloud sync** — everything lives in WebDAV, works across all your devices automatically
- 🔍 **Sort & filter** — by zone, A→Z, or show only IN/OUT items
- 📱 **Add to home screen** — PWA-ready with a custom icon; works offline when Nextcloud is unreachable

---

## The Story

PackTrack started as a single-page HTML app for one very specific problem: David housesits. He moves between 8–10 homes a year. He packs a bag, arrives at a house, and forgets what he brought. Where's the headlamp? The USB-C cables? The good scissors?

**v1** was just a list. Name + IN/OUT checkbox in a text file. Survivable.

**v2 (Nextcloud WebDAV)** turned it into a real system. The list moved to Nextcloud, so it synced across his Mac Mini, his phone, and his iPad without any manual effort. Green dot shows sync status. Works offline with localStorage fallback.

**v3 (PIN Protection)** made it shareable. When you're housesitting for someone else, you don't want their kids poking around your inventory. A 6-digit passcode — stored in Nextcloud, checked on every load — keeps it locked down.

**v4 (Photos)** changed everything. Items with photos are *instantly* recognizable. The thumbnail shows the actual thing — the specific backpack, the exact power supply. No more "wait, which of my three black bags is the camera bag?"

**v5 (Sort System)** added intelligence. Sort by room to see what you need for the kitchen. Filter to IN-only to see what's still unpacked. "X to go" counter tells you at a glance whether you're done.

**v6 (Zones Editor)** made it fully yours. Default zones are just a starting point. Add a Workshop. Rename "Living Room" to "Living". Delete a zone and its items flow to Unassigned automatically. Bulk select lets you move a dozen items to a new zone in two taps.

**v1.01 (Zones Polish)** refined the experience — a proper location manager panel, confirmation dialogs, per-zone color coding, and the "Unassigned" holding zone for items without a home yet.

---

## Tech

- **Pure HTML/JS** — no build step, no framework, no dependencies
- **Nextcloud WebDAV** — sync backend; works with any WebDAV host
- **PWA** — add to home screen, works offline
- **~1,500 lines** — readable, hackable, yours

---

## Live Demo

**`demo.html`** in this repo is the standalone demo. Open it directly in any browser — no server, no Nextcloud needed.

- PIN is `000000`
- Pre-loaded with 15 fake items
- **All core features work** — add items, toggle IN/OUT, sort, filter, zones editor, bulk select
- **Photo upload does NOT work in the demo** — `upload.php` doesn't exist in demo mode (see Requirements below)
- Data resets on page refresh (localStorage only, no backend)

To run the demo: download `demo.html` and open it in your browser, or host it on any static host.

---

## Requirements

PackTrack is **not a simple file drop** — it requires a specific backend setup:

### ✅ What you need

- **A Nextcloud instance** (self-hosted, or a Nextcloud subscription account) with:
  - WebDAV access enabled
  - A dedicated user account for PackTrack
  - A `packtrack_images/` folder in that user's WebDAV root
  - A `packlist.json` file (created automatically on first save)
  - A `.packtrack_pin.json` file (created on first PIN setup)

### ❌ What won't work

- **Regular shared hosting / WordPress / cPanel-only hosts** — these typically don't have Nextcloud or full WebDAV support
- **Generic static hosting** (Netlify, Vercel, GitHub Pages) — fine for `demo.html`, but the real app needs a WebDAV backend
- **Any host without PHP** (for `upload.php`) — photo upload will fail without the PHP proxy

> ⚠️ **If your host doesn't have Nextcloud with WebDAV access, the app will not function.** The entire data layer depends on Nextcloud's WebDAV API for reading, writing, and photo storage. There is no fallback for non-Nextcloud hosts.

### Photo upload note

Photo upload requires `upload.php` (a small PHP proxy) hosted alongside `packtrack.html`. This is intentional — direct browser-to-Nextcloud WebDAV PUT requests are blocked by CORS policy in most browser configurations. The PHP proxy handles the hop. Make sure your host supports PHP.

## Deploy Your Own

PackTrack has two files:

- **`packtrack.html`** — the real app (syncs to your Nextcloud)
- **`demo.html`** — standalone demo with fake data, no server needed

### Option A: Netlify (recommended — Git-based, auto-deploys)

**One-time setup (takes ~3 minutes):**

1. Push this repo to GitHub (done ✓)
2. Go to [app.netlify.com](https://app.netlify.com) → "Add new site" → "Import from GitHub"
3. Authorize Netlify to access your GitHub repos
4. Select `davidde67/packtrack`
5. Under **Build settings:**
   - Build command: `(leave blank)`
   - Publish directory: `/`
6. Click **Deploy site** — it deploys instantly
7. (Optional) Go to **Site settings → Domain management** → add a custom subdomain like `packtrack.yoursite.com`
8. Every push to `main` now auto-deploys! 🚀

**To update the demo URL in this README:** once you have the Netlify URL, do a PR or edit `README.md` with the real link.

---

### Option B: Any static host (SFTP, cPanel, etc.)

1. Download `packtrack.html` (the real app)
2. Edit the WebDAV constants at the top:
   ```js
   const WEBDAV_URL  = 'https://your-nextcloud.example.com/remote.php/dav/files/YOUR_USER/packlist.json';
   const WEBDAV_CODE_URL = 'https://your-nextcloud.example.com/remote.php/dav/files/YOUR_USER/.packtrack_pin.json';
   const WEBDAV_BASE = 'https://your-nextcloud.example.com/remote.php/dav/files/YOUR_USER/packtrack_images';
   const CREDENTIALS = btoa('YOUR_USER:YOUR_PASSWORD');
   ```
3. Upload to any web host — no server-side code needed.

---

## Get It Running

PackTrack is a single HTML file. Grab `packlist.html` from this repo and open it in any browser.

To sync across devices, point it at a Nextcloud WebDAV instance — any WebDAV host works. Edit these two lines near the top of the file:

```js
const WEBDAV_URL = 'https://your-nextcloud.example.com/remote.php/dav/files/YOUR_USER/';
const WEBDAV_AUTH = btoa('YOUR_USER:YOUR_PASSWORD');
```

Add it to your phone's home screen (PWA mode) and it works offline too.

> 💡 The version in this repo is clean and self-contained. David runs a customized version synced to his Nextcloud — the live URL is not included here.

---

## Changelog

| Version | Date | Highlights |
|---------|------|-----------|
| v1.0.2 | 2026-04-05 | Fix image upload — restored PHP proxy approach (direct WebDAV PUT blocked by CORS) |
| v1.01 | 2026-03-31 | Zones manager panel, confirmation modals, per-zone color coding, Unassigned zone |
| v6 | 2026-03-30 | Zones editor, bulk select, multi-select move, inline rename |
| v5 | 2026-03-30 | Sort system (room/A-Z/IN/OUT), zone filter buttons with counts, "X to go" |
| v4 | 2026-03-30 | Photo support per item, thumbnail browser, Nextcloud image storage |
| v3 | 2026-03-30 | 6-digit PIN auth screen, stored in Nextcloud |
| v2 | 2026-03-30 | Nextcloud WebDAV sync backend, cross-device sync |
| v1 | 2026-03-25 | Custom icon, iOS home screen meta tags |

---

## Why This Matters

Most inventory apps are built for warehouse managers. They're designed for barcodes, SKU numbers, and quarterly audits. PackTrack is built for **people who live out of bags**.

It's designed to be:
- **Fast to use** — three taps to mark an item IN or OUT
- **Quick to scan** — thumbnails let you visually confirm "yes, this is the right bag"
- **Shared safely** — PIN keeps clients out, sync keeps the family in
- **Yours forever** — pure HTML means no subscription, no company going under, no app store approval needed
