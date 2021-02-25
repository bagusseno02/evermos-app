create table master_packaging
(
    id         bigserial not null
        constraint master_packaging_pk
            primary key,
    code       varchar(10),
    name       varchar,
    is_deleted integer,
    created_at timestamp,
    created_by bigint,
    updated_at timestamp,
    updated_by bigint,
    deleted_at timestamp,
    deleted_by bigint
);

alter table master_packaging
    owner to seno;

