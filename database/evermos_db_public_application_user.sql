create table application_user
(
    id            bigserial            not null
        constraint application_user_pk
            primary key,
    username      varchar              not null,
    password      varchar              not null,
    is_active     boolean default true not null,
    token         varchar              not null,
    refresh_token varchar,
    expired_at    timestamp,
    created_at    timestamp,
    created_by    bigint,
    updated_at    timestamp,
    updated_by    bigint,
    deleted_at    timestamp,
    deleted_by    bigint
);

alter table application_user
    owner to seno;

create unique index application_user_username_uindex
    on application_user (username);

