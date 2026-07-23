# Form Audit

Audit date: 2026-07-23
Implementation updated: 2026-07-23

## 1. Summary

The Winter theme currently exposes one public website form: the contact form on the Contact page.

That form is not built with WPForms, Contact Form 7, Gravity Forms, Ninja Forms, Fluent Forms, Formidable Forms, Elementor forms, or a Gutenberg/block form. It is a custom hard-coded PHP form that submits to WordPress `admin-post.php` and is handled in theme code.

Spam protection has now been implemented for the hard-coded contact form using Cloudflare Turnstile, server-side Turnstile verification, a honeypot field, and the existing WordPress nonce protection.

## 2. Forms found

### Contact / enquiry form

- Purpose: public contact and service enquiry form
- Likely page URL: `/contact/`
- Template: `page-contact.php`
- Live output confirmed on `https://webstudiowa.com.au/contact/`
- Visible fields:
  - Name
  - Email
  - Phone
  - What can we help with?
  - Web Site Design
  - Website Redesign
  - Web Site Maintenance
  - Web Hosting
  - Message
  - Send enquiry

## 3. Form builder/system identified

### Contact / enquiry form

- Form system/type: hard-coded PHP form
- Submission pattern: custom `admin-post` submission
- Front-end form markup:
  - `page-contact.php`
- Submission handler:
  - `wswa_handle_contact_form()`
  - registered with `admin_post_wswa_contact`
  - registered with `admin_post_nopriv_wswa_contact`
- Action name:
  - `wswa_contact`

No evidence was found for these form builders/plugins in the theme code:

- WPForms
- Contact Form 7
- Gravity Forms
- Ninja Forms
- Fluent Forms
- Formidable Forms
- Elementor forms
- Gutenberg/block-based form plugin usage

## 4. File paths/templates involved

- `page-contact.php`
- `inc/setup.php`
- `assets/scss/main.scss`
- `assets/css/main.css`
- `docs/project-context.md`

Relevant implementation references:

- `page-contact.php` renders the public form, honeypot field, and conditional Turnstile widget, then posts to `admin-post.php`
- `inc/setup.php` validates the request, verifies nonce and Turnstile where configured, checks the honeypot, sanitises fields, sends email with `wp_mail()`, and redirects back to the contact page
- `assets/scss/main.scss` and `assets/css/main.css` contain styling for `.contact-form` and related contact-page classes only

## 5. Current spam protection status

### Existing validation/protection found

- WordPress nonce present via `wp_nonce_field('wswa_contact', 'wswa_contact_nonce')`
- Server-side nonce verification via `wp_verify_nonce(...)`
- Cloudflare Turnstile widget on the contact form when a site key is configured
- Server-side Turnstile verification before `wp_mail()` when both keys are configured
- Honeypot field named `company_website`
- Required-field validation for `name`, `email`, and `message`
- Email format validation via `is_email($email)`
- Input sanitisation:
  - `sanitize_text_field()`
  - `sanitize_email()`
  - `sanitize_textarea_field()`

## 6. Recommended next step

Implementation is complete in theme code.

Next step in WordPress admin:

- Enter the Cloudflare Turnstile site key and secret key in `Appearance -> Customize -> Web Studio WA Form Security`
- Test the live contact form after keys are entered

## 7. Notes

- Only one public form was found in the theme files scanned: the contact form in `page-contact.php`.
- The homepage includes a contact CTA in `template-parts/front-home.php`, but it links to the Contact page and does not contain form markup.
- The footer and header include contact links/CTAs only and do not include form markup.
- The live `/contact/` page content matches the hard-coded theme form structure.
- Turnstile keys are stored in the WordPress Customizer, not in theme code.
