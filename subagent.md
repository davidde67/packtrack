# Subagent: OpenClaw Health Check & Maintenance

## Goal
Check and maintain OpenClaw CLI installation, gateway refresh cycles, memory systems, and fix the "disappearing responses" glitch in the chat window. Also track and fix any other OpenClaw issues found.

## Context
- **User:** David De Anda (DJ), San Francisco CA
- **Assistant:** Fritz Langosta (🦞) — AI running in OpenClaw on MacBook Air
- **Machine:** MacBook Air, macOS 25.3.0 (arm64), Node v25.8.2
- **OpenClaw version:** 2026.4.2
- **Gateway:** LaunchAgent on port 18789, loopback-only
- **Tailscale:** CLI installed and connected, but OpenClaw has Tailscale mode="off" in config

## Completed Checks

### openclaw status
- Gateway: reachable, ws://127.0.0.1:18789, running pid 3267
- Service: LaunchAgent loaded
- Tailscale: OFF in OpenClaw config (CLI is connected, but OpenClaw integration disabled)
- Channels: Telegram ON and OK (@FritzLangostaBot, token config)
- Sessions: 2 active (main + subagent)
- Memory: 0 files, 0 chunks (concerning — should have MEMORY.md indexed)

### openclaw doctor
- Session locks: 1 found, pid 3267 alive, not stale — OK
- Telegram: ok, 954ms response time
- Plugins: 44 loaded, 41 disabled, 0 errors
- Skills: 9 eligible, 45 missing requirements
- Telegram pairing: needs to be completed (dmPolicy=pairing)

### Security Audit (--deep)
**CRITICAL:**
- `models.small_params`: qwen:7b (7B params) has NO sandbox and web_search/web_fetch enabled
  - Risk: Small models not recommended for untrusted inputs
  - Fix if needed: `agents.defaults.sandbox.mode="all"` + `tools.deny=["group:web","browser"]`
  - Note: David WANTS qwen:7b for cost savings. This is a known trade-off for a private single-user setup.

**WARNINGS:**
- `gateway.controlUi.allowInsecureAuth=true` — OK for local-only
- `tools.exec.security=full` — Known trade-off from earlier fix for exec pairing issue
- `gateway.nodes.denyCommands` entries are ineffective (exact match only) — low risk

### Disappearing Responses
- Not reproduced in current session
- May be related to [[reply_to_current]] tag behavior in webchat
- May be a page refresh/navigation issue on client side
- **Not found in gateway logs as an error**

### Memory 0 Files Issue
- `openclaw status` shows "Memory: 0 files · 0 chunks"
- But MEMORY.md exists at ~/.openclaw/workspace/MEMORY.md
- May be a display issue with `memory` plugin vs workspace files
- Workspace files (MEMORY.md, SOUL.md, USER.md, etc.) ARE being read normally

### Tailscale
- Tailscale CLI connected: macbook-air (100.110.145.10)
- OpenClaw config has `tailscale.mode: "off"`
- This is fine — Tailscale serve wasn't working as webhook relay anyway

## Issues to Fix

1. **[DONE] Telegram fresh install** — Config cleared, new bot @FritzLangostaBot installed, gateway restarted
2. **[INFO] qwen:7b sandboxing** — CRITICAL flag raised but David accepts risk for cost savings
3. **[INFO] Memory display** — 0 files shown but workspace files load fine, likely display bug
4. **[OPEN] Telegram pairing** — Need David to DM @FritzLangostaBot and we complete pairing
5. **[OPEN] Disappearing responses** — Not reproducible, may be client-side

## Actions Taken
- Wiped all Telegram config and runtime files (2026-04-04 19:24)
- Fresh install: @FritzLangostaBot token 8423750618:AAFyf2a_MZjGP9gNDkpgEWykgaotSjiCb4w
- Gateway restarted successfully

## Next Steps
1. Complete Telegram pairing (David DM @FritzLangostaBot with /start)
2. Monitor if disappearing responses happen again
3. Consider sandbox config for qwen:7b if security is a concern
