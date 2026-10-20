# Opusio – online portfolio generator (Laravel + Supabase PostgreSQL)

## 1. Install the files
Extract `MyProject.zip` **into the root of your existing Laravel project** (the folder that has `artisan`).
Choose "Replace" if asked. Two files are overwritten:

| File | Why |
|---|---|
| `routes/web.php` | new routes (replaces the default welcome route) |
| `app/Providers/AppServiceProvider.php` | forces https links when `APP_ENV=production` |
| `resources/views/*` | all pages and templates (redesign) |

No Composer packages and no npm/Vite build are needed.

## Design
The home page follows the layout of the supplied Dribbble reference (framed cream page, striped menu, giant headline,
floating avatars, scalloped "Join us now" badge, blue stat card) and the same look carries through every app page:
cream / navy / electric blue with yellow, salmon and sky accents, pill buttons, Dela Gothic One headings, Plus Jakarta Sans text.
Accessibility rules come from the **ui-ux-pro-max** skill (see `design-system/portfoliogen/MASTER.md`; its colour and font
choices were replaced by the reference style). Light and dark mode are automatic,
WCAG-minded forms (labels, inline errors, focusable error summary), visible focus rings, 44px controls,
reduced-motion support, SVG icons (no emoji), and a confirmation dialog before deleting.
The three templates use different styles from the skill: **Simple** = Swiss/editorial, **Modern** = Bento grid,
**Creative** = Neo-brutalism. New files: `resources/views/components/` (icon, field) and `partials/stepper.blade.php`.

### Light / dark mode
- The app (home, form, picker, manage, preview) has its own sun/moon toggle in the top menu.
- Each of the 3 portfolio templates has its **own separate toggle** (top-right of the page) and its own dark design.
  The two settings are stored separately in the browser, so they never affect each other.
- Both start from the visitor's system setting and remember the choice.

### Team section ("Meet the team")
At the bottom of the home page and the About page: one team leader and five members, each shown as a character.
Hover over the head (or focus it with the keyboard) and the character raises its hand; click the head to open a card with
name, school, contact number, email and social links. Everything comes from **`config/team.php`**: the leader is already
filled in, the five members are blank placeholders ("Not added yet"). To add a member, type their details into their entry
in that file and (optional) put their photo in `public/images/team/` and set `'photo' => 'images/team/name.jpg'`.
Run `php artisan config:clear` after editing. On touch screens, tapping the head raises the hand and opens the card.

### PDF download (one extra install step)
Every portfolio has a **Download PDF** button (preview page) and a **PDF** button (Manage page). The PDF follows the
template colours (navy/gold, indigo, or dark/cyan) and fits a typical portfolio on one A4 page.
It uses the standard Laravel package **dompdf**. Install it once in your project root:
```bash
composer require barryvdh/laravel-dompdf
```
Commit the updated `composer.json` and `composer.lock` so the Render/Docker build installs it too.
Until it is installed, the PDF buttons open the portfolio and the browser's **Save as PDF** print dialog automatically, so they still work.
If creating the PDF fails for another reason, the page shows the error (when `APP_DEBUG=true`) and details are written to `storage/logs/laravel.log`.
(The PDF layout was test-rendered with dompdf 3 in all three colour themes.)

### Interactive features and loading screen
- A loading screen (Opusio bars) shows on every page load and when you follow a link; each portfolio template has its own themed one.
- Sections reveal as you scroll, skill bars fill, numbers count up, cards lift on hover, hero shapes follow the pointer,
  there is a back-to-top button, a **Copy link** button on the preview page and a **Copy** button next to emails on portfolios.
- All motion switches off automatically for visitors whose device is set to "reduce motion".
- Fonts scale automatically: the base size grows smoothly from 15 px on small phones to 18 px on large screens.
- Manage page: square photo tiles; portfolios without a photo get a standard "unknown person" silhouette.

### Accounts and private portfolios (new)
- Visitors sign up / log in (`/register`, `/login`). Every portfolio now belongs to the account that created it (`portfolios.user_id`).
- Manage, create, edit, template picker, preview, save, Saved page and PDF all need a login, and only the **owner** can open them
  (anyone else gets a 404). The public link `/p/{id}` stays open but is **view-only**, and only the owner can switch templates on it.
- **Run `php artisan migrate`** (Railway runs it on deploy if you start with the Dockerfile). The new migration creates `users` /
  `sessions` only if your database does not already have them, adds `portfolios.user_id`, and turns on Row Level Security for the
  account tables (they contain password hashes).
- **Portfolios made before accounts existed** have no owner, so nobody can edit them. Give them to an account, for example:
  `php artisan tinker` then `App\Models\Portfolio::whereNull('user_id')->update(['user_id' => 1]);` (1 = the first user's id).
- Set `SESSION_DRIVER=database` in your environment (Railway variables and local `.env`) so logins survive redeploys.
- Not included: password reset by email (needs a mail service) and email verification.
- Name and professional title accept **letters only** (checked in the browser as you type and again on the server).
- Preview page: **Save** keeps the previewed template and opens the new **Saved** page (share link, PDF, edit, manage).

### The 3 templates
| Name | Style |
|---|---|
| **Formal** | Classic executive résumé: navy sidebar, gold accents, serif headings, print-friendly (Ctrl+P). |
| **Modern** | Frosted-glass cards over a soft gradient, sticky section menu, gradient accents. |
| **Aesthetic** | Cyber-tech HUD panels with neon colours that slowly cycle through the spectrum. Has a **pause** button and stops automatically if the device asks for reduced motion. |

The colour-cycling uses a newer CSS feature (`@property`); in very old browsers the colour simply stays cyan.
Database values stay `simple` / `modern` / `creative`, so portfolios you already saved keep working and just get the new look.

### Certificates (many photos)
The form has a **Certificates** section: choose several photos at once (up to 10 per portfolio, JPG/PNG/WEBP, 5 MB each),
preview them, and remove any before saving. They are resized to 1400 px, stored in a new `certificates` table and shown as a
gallery in all three templates (tap a photo to enlarge it; arrow keys move between them). They are also printed in the PDF.
**Run `php artisan migrate` again** to create the new table. PHP must allow bigger uploads for several photos:
`upload_max_filesize = 6M`, `post_max_size = 64M`, `max_file_uploads = 20`, `memory_limit = 512M` (the Docker deploy already sets these).

### Profile photo (up to 5 MB)
Photos up to 5 MB are accepted and are automatically scaled to 900 px (needs PHP's `gd` extension, which XAMPP/Laragon enable by default).
PHP itself must allow the upload: in `php.ini` set `upload_max_filesize = 6M` and `post_max_size = 64M`, then restart.
(With `php artisan serve` the default is only 2 MB, so change it in the php.ini that `php --ini` shows.) The Docker deploy already sets this.

### Use it on phones, tablets and other computers
- Layouts are responsive (phone, tablet, desktop) and controls are touch-friendly (44px targets).
- **While developing:** run `php artisan serve --host=0.0.0.0 --port=8000`, connect the phone to the same Wi-Fi,
  then open `http://<your-computer-IP>:8000` (find the IP with `ipconfig` on Windows). Allow PHP through the firewall if asked.
- **Anywhere:** deploy to Render (section 5) and open the `https://...onrender.com` link on any device.
  Each portfolio's own link `/p/{id}` can be shared and opens on any device.

## 2. Create the Supabase database
1. Go to https://supabase.com → **New project** (e.g. name it "Opusio"). Save the database password.
2. Click **Connect** (top of the dashboard) → choose **Session pooler** and note the host, port, and user.
   - Host: `aws-0-<region>.pooler.supabase.com`
   - Port: `5432`
   - User: `postgres.<project-ref>`
   - Database: `postgres`

> Use the **Session pooler**, not the "Direct connection": the direct host is IPv6-only and fails on many
> home networks and on hosts such as Render.

## 3. Configure `.env`
Open `.env.supabase.example`, copy the values into your Laravel `.env`, and fill in your host, user and password.

Make sure PHP's PostgreSQL driver is on. XAMPP/Laragon: in `php.ini` enable
`extension=pdo_pgsql` and `extension=pgsql`, then restart Apache.

## 4. Create the tables and run
```bash
php artisan config:clear
php artisan migrate      # creates the 6 tables in Supabase
php artisan serve        # http://127.0.0.1:8000
```
Open Supabase → **Table Editor** to see the saved data (useful to show your instructor).

## 5. Publish online (Render, free)
Vercel/Netlify/GitHub Pages cannot run Laravel/PHP, so use **Render** (a Dockerfile is included).
1. Push the project to GitHub (`.env` is already ignored by Laravel's `.gitignore`).
2. render.com → **New → Web Service** → pick the repo → Runtime: **Docker**.
3. Add **Environment Variables**:
   `APP_KEY` (run `php artisan key:generate --show` locally and paste the result), `APP_ENV=production`,
   `APP_DEBUG=false`, `APP_URL=https://<your-service>.onrender.com`, `DB_CONNECTION=pgsql`, `DB_HOST`, `DB_PORT=5432`,
   `DB_DATABASE=postgres`, `DB_USERNAME`, `DB_PASSWORD`, `DB_SSLMODE=require`, `SESSION_DRIVER=file`, `CACHE_STORE=file`.
4. Deploy. Migrations run automatically at start-up. Your URL is the `onrender.com` link.
   (Free instances sleep when idle; the first visit may take ~1 minute.)

## 6. Pages / flow
**Information pages:** `/about` (what Opusio is, sections, templates, how it is built), `/faq` (11 questions),
`/privacy` (what is stored, where, cookies, how to delete). The home page also shows a facts strip (the portfolio count
is read live from the database), the seven portfolio sections, who it is for, features, tech stack and a FAQ preview.
The footer links to everything. No testimonials, client logos or invented statistics are used; if you later add a contact
email or real reviews, put them in `resources/views/pages/` and the footer in `layouts/app.blade.php`.

**App flow:**
`/` Home → `/portfolios/create` Information form → saved to Supabase → `/portfolios/{id}/templates`
Select 1 of 3 → `/portfolios/{id}/preview` Preview → `/portfolios` Manage (View / Edit / Delete).
The generated portfolio has its own shareable link: `/p/{id}`.

## 7. Database structure (for your documentation)
```
portfolios    id, slug (unique), full_name, job_title, email, phone, address, about,
              profile_picture (data URI), template (simple|modern|creative), timestamps
educations    id, portfolio_id → portfolios.id (CASCADE), school, degree, start_year, end_year, description, sort_order
skills        id, portfolio_id → portfolios.id (CASCADE), name, level, sort_order
projects      id, portfolio_id → portfolios.id (CASCADE), title, description, tech, url, sort_order
certificates  id, portfolio_id → portfolios.id (CASCADE), image (data URI), sort_order
experiences   id, portfolio_id → portfolios.id (CASCADE), company, position, start_date, end_date, description, sort_order
social_links  id, portfolio_id → portfolios.id (CASCADE), platform, url, sort_order
```
One portfolio has many educations / skills / projects / experiences / links (1-to-many).
Deleting a portfolio removes all its rows automatically. Row Level Security is enabled on every table so the
public Supabase API key cannot read them; Laravel connects with the database user instead.

## 8. Submission reminders
- Never submit `.env` or your database password.
- Database platform: Supabase (PostgreSQL). Hosting: Render. Framework: Laravel.
- Take screenshots of every page and each of the 3 templates for the documentation.
