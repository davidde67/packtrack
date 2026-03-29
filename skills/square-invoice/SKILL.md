---
name: square-invoice
description: Create and send Square invoices directly from client notes. Use when the user finishes a client session and wants to immediately generate a professional invoice while still on-site. Takes raw notes (text or voice transcribed), extracts client info + service description + time, and creates a customer/order/invoice in Square and publishes it — all via the Square API. Works with the Square Sandbox for testing and production Square account for live invoicing.
compatibility: Requires Square developer account and API access token. Works with both sandbox and production Square environments.
license: MIT
homepage: https://developer.squareup.com/docs/invoices-api
---

# Square Invoice Skill

## Overview

This skill creates Square invoices directly from raw client notes. It handles:
1. Extracting client name, contact info, service description, and time
2. Looking up or creating the customer in Square
3. Creating an order with line items
4. Creating and publishing the invoice

## Pricing (David's Rates)

| Duration | Amount |
|---|---|
| 1 hour | $125.00 |
| 30 minutes | $62.50 |
| 15 minutes | $31.25 |

- **Minimum charge:** 1 hour
- **After minimum:** billed in 15-minute increments at $31.25 each

## Business Info

- **Business:** David De Anda / Smart Configurations
- **Address:** 5342 Geary Boulevard, #765, San Francisco CA 94121
- **Phone:** (323) 691-7000
- **Invoice number format:** 6 digits starting from 06172221

## API Credentials

### Production ✅ (ACTIVE)
- **Base URL:** `https://connect.squareup.com/v2`
- **Access Token:** `EAAAlyCnUtkWG2NbGijNOZWA9t314gYgAUyg4FoIUUFto5x8vmnomzgkpn7Odbfh`
- **Location ID:** `LW34Q2JD27SZ2`
- **Location Name:** Smart Configurations (Remote Support)

### Sandbox (testing)
- **Base URL:** `https://connect.squareupsandbox.com/v2`
- **Access Token:** `EAAAl7lZ-kpK8eBwBY6hcpvHGFHS7pvI_ublK6mNqxaeYIFXMFWYxHlBhIx6u_FD`
- **Location ID:** `L1QY5N537CZGX`

## Invoice Creation Flow

### Step 1 — Create or Find Customer

```bash
# Search for existing customer by email
curl -s -X POST "{BASE_URL}/customers/search" \
  -H "Authorization: Bearer {TOKEN}" \
  -H "Content-Type: application/json" \
  -d '{"query": {"filter": {"email_address": {"exact": "CLIENT_EMAIL"}}}, "limit": 5}'

# If not found, create customer:
curl -s -X POST "{BASE_URL}/customers" \
  -H "Authorization: Bearer {TOKEN}" \
  -H "Content-Type: application/json" \
  -d '{
    "given_name": "FIRST_NAME",
    "family_name": "LAST_NAME",
    "email_address": "CLIENT_EMAIL",
    "phone_number": "CLIENT_PHONE",
    "company_name": "CLIENT_COMPANY",
    "address": {
      "address_line_1": "STREET",
      "locality": "CITY",
      "administrative_district_level_1": "STATE",
      "postal_code": "ZIP",
      "country": "US"
    }
  }'
```

### Step 2 — Create Order

```bash
curl -s -X POST "{BASE_URL}/orders" \
  -H "Authorization: Bearer {TOKEN}" \
  -H "Content-Type: application/json" \
  -d '{
    "idempotency_key": "{UUID}",
    "order": {
      "location_id": "{LOCATION_ID}",
      "line_items": [
        {
          "name": "{SERVICE_TITLE}",
          "description": "{SERVICE_DESCRIPTION}",
          "quantity": "1",
          "base_price_money": {
            "amount": {AMOUNT_CENTS},
            "currency": "USD"
          }
        }
      ]
    }
  }'
```

Response contains `order.id`.

### Step 3 — Create Invoice

```bash
curl -s -X POST "{BASE_URL}/invoices" \
  -H "Authorization: Bearer {TOKEN}" \
  -H "Content-Type: application/json" \
  -d '{
    "idempotency_key": "{UUID}",
    "invoice": {
      "location_id": "{LOCATION_ID}",
      "order_id": "{ORDER_ID}",
      "primary_recipient": {
        "customer_id": "{CUSTOMER_ID}"
      },
      "invoice_number": "{INVOICE_NUMBER}",
      "title": "{BUSINESS_NAME} - Professional Services",
      "scheduled_at": "{ISO_TIMESTAMP}",
      "delivery_method": "EMAIL",
      "payment_requests": [
        {
          "request_type": "BALANCE",
          "due_date": "{DUE_DATE}"
        }
      ],
      "accepted_payment_methods": {
        "card": true,
        "bank_account": true
      }
    }
  }'
```

Response contains `invoice.id` and `invoice.version`.

### Step 4 — Publish Invoice

```bash
curl -s -X POST "{BASE_URL}/invoices/{INVOICE_ID}/publish" \
  -H "Authorization: Bearer {TOKEN}" \
  -H "Content-Type: application/json" \
  -d '{
    "idempotency_key": "{UUID}",
    "version": {INVOICE_VERSION}
  }'
```

Invoice status becomes `SCHEDULED` and is emailed to the customer.

## Prompt Templates

### When Client Notes Come In

Extract from the user's notes:
- Client name and contact info (email, phone, company)
- Service description
- Time spent (calculate amount from rate table)
- Invoice number (increment from last used)

### Confirmation Message to User

```
✅ Invoice #{NUMBER} created and sent to {CLIENT_EMAIL}
📋 {CLIENT_NAME} — {COMPANY}
💰 ${AMOUNT}
📅 Due: {DUE_DATE}
```

## Notes

- Always use `uuidgen` for idempotency keys
- Invoice numbers must be unique per location
- Amounts in API calls are in **cents** (multiply dollars by 100)
- `scheduled_at` must be in the future when publishing
- For production: swap base URL, token, and location ID from TOOLS.md
