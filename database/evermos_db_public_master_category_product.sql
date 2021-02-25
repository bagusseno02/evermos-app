create table master_category_product
(
    id         bigserial not null
        constraint master_category_product_pk
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

alter table master_category_product
    owner to seno;

