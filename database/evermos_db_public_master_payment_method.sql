create table master_payment_method
(
    id         bigserial not null
        constraint master_payment_method_pk
            primary key,
    code       varchar(10),
    name       varchar,
    created_at timestamp,
    created_by bigint,
    updated_at timestamp,
    updated_by bigint,
    deleted_at timestamp,
    deleted_by bigint,
    is_deleted boolean default false
);

alter table master_payment_method
    owner to seno;

