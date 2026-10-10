-- =====================================================================
--  Opusio  |  Certificates feature  |  Supabase (PostgreSQL)
-- ---------------------------------------------------------------------
--  Run this in:  Supabase dashboard > SQL Editor > New query > Run
--  Use it when your Supabase project ALREADY has the portfolio tables
--  (portfolios, educations, skills, ...) and you only need the new
--  "certificates" table. Starting from an empty project? Run
--  00_full_schema.sql instead (it already includes this table).
--
--  Safe to run more than once: nothing is dropped or overwritten.
--  It mirrors database/migrations/2025_06_01_000001_create_certificates_table.php
-- =====================================================================

-- 0. Stop early with a clear message if the parent table is missing ----
do $$
begin
    if to_regclass('public.portfolios') is null then
        raise exception 'Table "portfolios" not found. Run 00_full_schema.sql first (or "php artisan migrate").';
    end if;
end $$;

-- 1. Table: one row per certificate photo ------------------------------
--    image = the resized photo stored as a data URI (data:image/...;base64,...)
--            so it survives on cloud hosts. The PDF export reads this same column.
create table if not exists public.certificates (
    id            bigserial primary key,
    portfolio_id  bigint       not null,
    image         text         not null,
    sort_order    smallint     not null default 0,
    created_at    timestamp(0) without time zone,
    updated_at    timestamp(0) without time zone,
    constraint certificates_portfolio_id_foreign
        foreign key (portfolio_id) references public.portfolios (id) on delete cascade
);

-- 2. Index: Postgres does not index foreign keys on its own. The app always
--    loads "certificates of one portfolio, in order" ------------------------
create index if not exists certificates_portfolio_id_sort_order_index
    on public.certificates (portfolio_id, sort_order);

-- 3. Row Level Security: Supabase exposes the public schema through its REST
--    API. RLS with no policies keeps the table closed to the anon key; Laravel
--    connects as the database owner, which is not affected -----------------
alter table public.certificates enable row level security;

-- 4. Tell Laravel this migration is already applied, so "php artisan migrate"
--    (your Docker start-up runs it on every deploy) does not try to create the
--    table again and fail with "relation already exists" -------------------
create table if not exists public.migrations (
    id         serial primary key,
    migration  varchar(255) not null,
    batch      integer      not null
);

do $$
begin
    if not exists (select 1 from public.migrations
                   where migration = '2025_06_01_000001_create_certificates_table') then
        insert into public.migrations (migration, batch)
        values ('2025_06_01_000001_create_certificates_table',
                (select coalesce(max(batch), 0) + 1 from public.migrations));
    end if;
end $$;

-- 5. Check: you should see 6 columns (id, portfolio_id, image, sort_order,
--    created_at, updated_at) --------------------------------------------
select column_name, data_type, is_nullable, column_default
from information_schema.columns
where table_schema = 'public' and table_name = 'certificates'
order by ordinal_position;
