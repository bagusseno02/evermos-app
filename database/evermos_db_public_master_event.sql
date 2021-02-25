create table master_event
(
    id         bigserial not null
        constraint master_event_pk
            primary key,
    name       varchar,
    code       varchar(10),
    start_date timestamp,
    end_date   timestamp,
    created_at timestamp,
    created_by bigint,
    updated_at timestamp,
    updated_by bigint,
    deleted_at timestamp,
    deleted_by bigint,
    is_deleted integer
);

alter table master_event
    owner to seno;

