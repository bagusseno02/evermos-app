create table master_product
(
    id                  bigserial   not null
        constraint master_product_pk
            primary key,
    name                varchar     not null,
    code                varchar(10) not null,
    category_product_id bigint      not null
        constraint master_product_master_category_product_id_fk
            references master_category_product,
    price               numeric,
    expired_date        date,
    bpom_number         varchar,
    supplier_id         bigint
        constraint master_product_master_supplier_id_fk
            references master_supplier,
    packaging_id        bigint
        constraint master_product_master_packaging_id_fk
            references master_packaging,
    created_at          timestamp,
    created_by          bigint,
    updated_at          timestamp,
    updated_by          bigint,
    deleted_at          timestamp,
    deleted_by          bigint,
    is_deleted          boolean default false,
    price_event         numeric,
    stock               bigint,
    event_id            bigint
        constraint master_product_master_event_id_fk
            references master_event
);

alter table master_product
    owner to seno;

