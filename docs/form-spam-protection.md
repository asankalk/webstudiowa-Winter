# Form Spam Protection

Updated: 2026-07-23

## What was added

- Cloudflare Turnstile support for the hard-coded contact form
- Server-side Turnstile verification before email sending
- A honeypot field named `company_website`
- Existing WordPress nonce protection retained
- Existing sanitisation and validation retained

## Where to enter keys

In WordPress admin, go to:

`Appearance -> Customize -> Web Studio WA Form Security`

Enter:

- `Cloudflare Turnstile Site Key`
- `Cloudflare Turnstile Secret Key`

Keys are stored in WordPress settings and are not committed in the theme codebase.

## How to create Cloudflare Turnstile keys

1. Open the Cloudflare Dashboard.
2. Go to `Turnstile`.
3. Choose `Add site`.
4. Create a widget for the domain below.

Domain to use:

- `webstudiowa.com.au`

## Important reminder

- Do not commit keys to GitHub.
- Do not hardcode keys in theme files.

## Testing steps

1. Visit `/contact/`.
2. Submit the form with valid details.
3. Confirm the enquiry email arrives.
4. Confirm the form still works on mobile.
5. Confirm the Turnstile widget appears after keys are configured.
6. Confirm submissions still work if keys are not yet configured and the widget is not shown.
