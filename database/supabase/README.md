# Supabase database – Certificates feature

Extract the zip into the **root of your Laravel project** (the folder with `artisan`). It only adds the
`database/supabase/` folder; nothing in your project is overwritten.

| File | Run it when |
|---|---|
| `01_certificates.sql` | Your Supabase project **already has** the portfolio tables and you only need the new `certificates` table. |
| `00_full_schema.sql` | Your Supabase project is **new/empty**. Creates all 7 tables (including `certificates`) in one go. |

Run **one** of them, not both.

## How to run
1. Supabase dashboard → your project → **SQL Editor** → **New query**.
2. Paste the whole file → **Run**.
3. The result grid at the bottom confirms it worked. Check **Table Editor** → `certificates`.

Both files are safe to run again: nothing is dropped and no data is overwritten.

## The new table

```
certificates   id, portfolio_id → portfolios.id (ON DELETE CASCADE), image (text, data URI),
               sort_order (default 0), created_at, updated_at
```

- Same columns as `database/migrations/2025_06_01_000001_create_certificates_table.php`, plus an index on
  `(portfolio_id, sort_order)` because the app always loads one portfolio's certificates in order.
- Row Level Security is on with no policies, like your other tables: the public Supabase key cannot read it,
  Laravel (connected as the database owner) can.
- Deleting a portfolio deletes its certificates automatically.
- Photos are stored inside the database, so they count toward your Supabase database size.

## `php artisan migrate`
The SQL also records the certificates migration in Laravel's `migrations` table. Your Docker start-up runs
`php artisan migrate` on every deploy, and without this record it would try to create the table again and fail with
"relation already exists". After running the SQL, `migrate` simply reports nothing to migrate.

## PDF download
The PDF is built on the fly from the data above, so it needs **no table of its own**. It only needs the package:
```bash
composer require barryvdh/laravel-dompdf
```
