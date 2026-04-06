# MEMORY.md - Long-Term Memory

## David De Anda (DJ)
- Lives in San Francisco with June (wife). Professional housesitters.
- Has ADHD and ASD. Working with therapist on executive function challenges.
- Communication: Fritz should use gentle nudges for David.
- Phone: 323 area code (SF-based)

## Trash Days (Recology SF)
- **391 Lakeshore Dr, SF 94132 (David & June's home):** Tuesday — confirmed by David ("today is trash day" on Tue 3/31)
- **10 Margaret Ave, SF 94112 (Diana & Bill's, Nietzsche 🐰):** Friday (Excelsior/Southwest zone)

## Housesitting
- **Current (April 2+):** Diana & Bill's, 10 Margaret Ave, SF 94112 — bunny Nietzsche 🐰, trash day Friday
- **Previous:** 391 Lakeshore Dr, SF CA 94132 (ended April 1)
- Pet Sitting spreadsheet: https://docs.google.com/spreadsheets/d/1F5ihKDTPPjCW62VtkgctVsEtrnXPhPowNw7F0ZDW-_8
- **Note:** David & June are DJ (David+June) — professional housesitters

## Car Buying Trip — June's Niece
- June's niece buying a car
- Car is in the SF Peninsula in San Carlos
- Meeting scheduled for Sunday, April 5.

## Morning Brief System — PRIORITY
- David needs a DAILY morning check-in system
- Purpose: review appointments, important reminders, tasks for the day
- Addresses executive function challenges (ADHD/ASD)
- David forgets to check calendar, misses appointments, disappoints people
- Wants something that INSPIRES focus, not just lists
- Looking into OpenClaw Mission Control as customizable solution
- Need to research options and implement


## Parking — PRIORITY
- Street sweeping is a major pain point. Has lost thousands to tickets.
- **Current location (391 Lakeshore Dr):**
  - Tuesday side of Lakeshore = park there on Monday to avoid Tuesday ticket
  - Wednesday side = park there on Tuesday to avoid Wednesday ticket
  - Pattern: move car day before sweeping
  - Car was moved Sunday March 29 night (to Tuesday side). Needs moving Monday for Tuesday side.
- Need to establish a reliable reminder system.

## April Trip — CANCELLED
- April 15-25 motorcycle/camping trip with brother Jim — CANCELLED
- Reason: Weather too cold in planned riding area; plans changed
- Jim agreed to move the camping trip to MAY instead
- Mallorca, Spain trip with Jim is September (separate trip)
- Jim has ASD — Jim is sensitive to need for advance notice and stability of plans
- **June's family trip (East Coast) now takes priority for April**
  - Already booked: flights + car rental + hotel, ~$2,500 non-refundable
  - If David doesn't go: $1,250+ loss (June goes alone)
  - David is going with June to East Coast in April (April 15-25 window)
- Jim's trip now in April again with his friends; David not going as he will be in Virginia/Texas

## June's Family Trip (East Coast)
- April 16-28 window
- Flights, car rental, hotel already booked — ~$2,500 non-refundable
- David attending with June
- Visit June's family back in Virginia & Texas

## Jim Camping Trip (May)
- Probably canceled, as we are waiting on his petsitter Crystal to be available next, after April

## PackTrack (Housesit Inventory)
- **URL:** https://smartconfigurations.com/nextcloud/remote.php/dav/files/ow9cg/packlist.html
- **WebDAV credentials:** user=ow9cg, pass=k9KE?6a7m%66I
- **Zones/locations:** synced to .packtrack_zones.json on Nextcloud (Kitchen, Bath, Bedroom, Living, Dining, Office, Garage, Storage, Unassigned)
- **Features built today (2026-03-31):**
  - "Locations" button in header opens location manager panel
  - Add/delete locations (delete blocked if location has items — bulk-move TBD)
  - "Unassigned" is permanent holding zone for items without a location
  - Confirmation modal for deletion with item count
- **Color scheme:** dark (#0f1117), accent purple (#6c63ff), in=green (#22c55e), out=red (#ef4444)
- **Zones color-coded in UI** — Kitchen=orange, Bath=sky, Bedroom=purple, Living=yellow, Dining=green, Office=indigo, Garage=amber, Storage=gray; custom/user zones get purple

## Technical / Preferences
- Concerned about token burn with larger models
- Currently running MiniMax-M2.7 (lean, cost-effective)
- Strategy: Use memory files as bridge between Telegram (mobile) and web chat (heavy-lift) sessions
- After big work sessions: dump key outcomes to memory so mobile layer stays useful
- **API Keys location:** Apple Note "API Keys for David - Fritz Langosta Jr." — search here first for any API keys (Minimax, Exa, etc.)

## OpenClaw Setup (MacBook Air — new machine, April 2026)
- **Gateway LaunchAgent:** Installs to ~/Library/LaunchAgents/ai.openclaw.gateway.plist
- **LaunchAgent sleep issue (known bug #43602):** LaunchAgent silently unloads after macOS sleep/idle
  - Fix: sleepwatcher installed via `brew install sleepwatcher`
  - ~/.wakeup script runs `openclaw gateway install` on wake
  - `brew services start sleepwatcher` to keep it running
  - PR #43619 (fix) still open — not yet merged as of 2026.4.1
- **Exec tool pairing issue (FIXED):** 
  - After machine migration, exec got "pairing required" error — gateway wasn't routing exec properly
  - Fix: `openclaw config set tools.exec.host gateway && openclaw config set tools.exec.security full && openclaw config set tools.exec.ask off && openclaw gateway restart`
  - Now working normally

## Business - Smart Configurations
- David: david@smartconfigurations.com | (323) 691-7000
- Invoicing: Square, $125/hr, next invoice #06172223
- Rate structure: $125/hr · $62.50/30min · $31.25/15min · 1hr minimum
- OpenClaw update available: 2026.4.2 (run `npm update openclaw` to upgrade)

## Flights — East Coast Trip (April 16-28, 2026)
- **Flight 1:** UA2740 · Thu Apr 16 · 1:55 PM → 10:18 PM · SFO → IAD (Washington DC)
- **Flight 2:** UA2116 · Tue Apr 21 · 5:50 PM → 8:28 PM · IAD → DFW (Dallas)
- **Flight 3:** UA1718 · Tue Apr 28 · 6:12 PM → 8:10 PM · DFW → SFO
