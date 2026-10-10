-- =====================================================================
--  Opusio  |  FULL database schema  |  Supabase (PostgreSQL)
-- ---------------------------------------------------------------------
--  Run this in:  Supabase dashboard > SQL Editor > New query > Run
--  Use it for a NEW / empty Supabase project: it creates all 7 tables,
--  including the new "certificates" table, in one go.
--  Already have the portfolio tables? Run 01_certificates.sql instead.
--
--  Safe to run more than once: every statement is "if not exists", so
--  existing tables and their data are never dropped or overwritten.
--  It mirrors everything in database/migrations/.
-- =====================================================================

-- 1. portfolios --------------------------------------------------------
create table if not exists public.portfolios (
    id               bigserial primary key,
    slug             varchar(32)  not null,
    full_name        varchar(150) not null,
    job_title        varchar(150),
    email            varchar(150) not null,
    phone            varchar(40)  not null,
    address          varchar(255) not null,
    about            text         not null,
    profile_picture  text,                                  -- data URI
    template         varchar(20)  not null default 'simple', -- simple | modern | creative
    created_at       timestamp(0) without time zone,
    updated_at       timestamp(0) without time zone,
    constraint portfolios_slug_unique unique (slug)
);

-- 2. educations --------------------------------------------------------
create table if not exists public.educations (
    id            bigserial primary key,
    portfolio_id  bigint       not null,
    school        varchar(200) not null,
    degree        varchar(200) not null,
    start_year    varchar(10),
    end_year      varchar(10),
    description   text,
    sort_order    smallint     not null default 0,
    created_at    timestamp(0) without time zone,
    updated_at    timestamp(0) without time zone,
    constraint educations_portfolio_id_foreign
        foreign key (portfolio_id) references public.portfolios (id) on delete cascade
);

-- 3. skills ------------------------------------------------------------
create table if not exists public.skills (
    id            bigserial primary key,
    portfolio_id  bigint       not null,
    name          varchar(100) not null,
    level         varchar(20)  not null default 'Intermediate',
    sort_order    smallint     not null default 0,
    created_at    timestamp(0) without time zone,
    updated_at    timestamp(0) without time zone,
    constraint skills_portfolio_id_foreign
        foreign key (portfolio_id) references public.portfolios (id) on delete cascade
);

-- 4. projects ----------------------------------------------------------
create table if not exists public.projects (
    id            bigserial primary key,
    portfolio_id  bigint       not null,
    title         varchar(200) not null,
    description   text,
    tech          varchar(200),
    url           varchar(255),
    sort_order    smallint     not null default 0,
    created_at    timestamp(0) without time zone,
    updated_at    timestamp(0) without time zone,
    constraint projects_portfolio_id_foreign
        foreign key (portfolio_id) references public.portfolios (id) on delete cascade
);

-- 5. experiences -------------------------------------------------------
create table if not exists public.experiences (
    id            bigserial primary key,
    portfolio_id  bigint       not null,
    company       varchar(200) not null,
    position      varchar(200) not null,
    start_date    varchar(30),
    end_date      varchar(30),
    description   text,
    sort_order    smallint     not null default 0,
    created_at    timestamp(0) without time zone,
    updated_at    timestamp(0) without time zone,
    constraint experiences_portfolio_id_foreign
        foreign key (portfolio_id) references public.portfolios (id) on delete cascade
);

-- 6. social_links ------------------------------------------------------
create table if not exists public.social_links (
    id            bigserial primary key,
    portfolio_id  bigint       not null,
    platform      varchar(50)  not null,
    url           varchar(255) not null,
    sort_order    smallint     not null default 0,
    created_at    timestamp(0) without time zone,
    updated_at    timestamp(0) without time zone,
    constraint social_links_portfolio_id_foreign
        foreign key (portfolio_id) references public.portfolios (id) on delete cascade
);

-- 7. certificates  (NEW) -----------------------------------------------
--    image = the resized photo stored as a data URI (data:image/...;base64,...)
--            The PDF export reads this same column; it has no table of its own.
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

-- Postgres does not index foreign keys on its own. The app always loads
-- "certificates of one portfolio, in order".
create index if not exists certificates_portfolio_id_sort_order_index
    on public.certificates (portfolio_id, sort_order);

-- 8. Row Level Security -------------------------------------------------
--    Supabase exposes the public schema through its REST API. RLS with no
--    policies keeps every table closed to the anon key; Laravel connects as
--    the database owner, which is not affected.
alter table public.portfolios    enable row level security;
alter table public.educations    enable row level security;
alter table public.skills        enable row level security;
alter table public.projects      enable row level security;
alter table public.experiences   enable row level security;
alter table public.social_links  enable row level security;
alter table public.certificates  enable row level security;

-- 9. Tell Laravel these migrations are already applied, so "php artisan
--    migrate" (your Docker start-up runs it on every deploy) does not try to
--    create the tables again and fail with "relation already exists".
create table if not exists public.migrations (
    id         serial primary key,
    migration  varchar(255) not null,
    batch      integer      not null
);

do $$
declare
    m    text;
    next_batch integer;
begin
    select coalesce(max(batch), 0) + 1 into next_batch from public.migrations;

    foreach m in array array[
        '2025_01_01_000001_create_portfolios_table',
        '2025_01_01_000002_create_educations_table',
        '2025_01_01_000003_create_skills_table',
        '2025_01_01_000004_create_projects_table',
        '2025_01_01_000005_create_experiences_table',
        '2025_01_01_000006_create_social_links_table',
        '2025_01_01_000007_enable_rls_on_supabase',
        '2025_06_01_000001_create_certificates_table'
    ]
    loop
        if not exists (select 1 from public.migrations where migration = m) then
            insert into public.migrations (migration, batch) values (m, next_batch);
        end if;
    end loop;
end $$;

-- 10. Check: you should see 7 tables, each with RLS on (rls_enabled = true) --
select c.relname as table_name, c.relrowsecurity as rls_enabled
from pg_class c
join pg_namespace n on n.oid = c.relnamespace
where n.nspname = 'public'
  and c.relkind = 'r'
  and c.relname in ('portfolios', 'educations', 'skills', 'projects',
                    'experiences', 'social_links', 'certificates')
order by c.relname;
