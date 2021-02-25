create table orders
(
    id               bigserial not null
        constraint orders_pk
            primary key,
    shopping_cart_id bigint
        constraint orders_shopping_cart_id_fk
            references shopping_cart (id),
    orders_date      date,
    orders_time      time,
    created_at       timestamp,
    created_by       bigint,
    updated_at       timestamp,
    updated_by       bigint,
    deleted_at       timestamp,
    deleted_by       bigint
);

alter table orders
    owner to seno;

