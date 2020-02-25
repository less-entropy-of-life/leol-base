create database leol with encoding = 'utf8';
create user leoladmin with encrypted password 'leol';
grant all privileges on database leol to leoladmin;

create table if not exists leol.user_profile (
    id bigserial primary key,
    first_name varchar(255) not null,
    last_name varchar(255),
    pin varchar(32) not null,
    picture varchar(255) not null default '/storage/user/default/picture.jpg'
);

create table if not exists leol.user_session (
    id bigserial primary key,
    user_id bigint not null references leol.user_profile(id) on delete cascade,
    access_token varchar(32) not null unique,
    created_at timestamp not null default now()
);

create table if not exists leol.user_category (
    id bigserial primary key,
    title varchar (255) not null,
    user_id bigint not null references leol.user_profile(id) on delete cascade,
    unique(title, user_id)
);

create table if not exists leol.user_todo_task (
    id bigserial primary key,
    title varchar (255) not null,
    description text,
    user_id bigint not null references leol.user_profile(id) on delete cascade
);