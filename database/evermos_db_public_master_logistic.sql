create table master_logistic
(
    id         bigserial   not null
        constraint master_logistic_pk
            primary key,
    code       varchar(10) not null,
    name       varchar     not null,
    is_deleted boolean default false,
    created_at timestamp,
    created_by bigint,
    updated_at timestamp,
    updated_by bigint,
    deleted_at timestamp,
    deleted_by bigint
);

alter table master_logistic
    owner to seno;

