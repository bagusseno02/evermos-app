create table shopping_cart_detail
(
    id                       bigserial not null
        constraint shopping_cart_detail_pk
            primary key,
    product_id               bigint,
    shopping_cart_id         bigint    not null
        constraint shopping_cart_detail_shopping_cart_id_fk
            references shopping_cart (id),
    transaction_number       varchar,
    qty                      bigint    not null,
    total_amount_per_product numeric   not null,
    created_at               timestamp,
    created_by               bigint,
    updated_at               timestamp,
    updated_by               bigint,
    deleted_at               timestamp,
    deleted_by               bigint,
    product_event_id         bigint
);

alter table shopping_cart_detail
    owner to seno;

