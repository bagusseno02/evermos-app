create table shopping_cart
(
    id                 bigserial not null
        constraint shopping_cart_pk
            primary key,
    user_id            bigint    not null
        constraint orders_master_user_id_fk
            references master_user,
    total_amount       numeric,
    expired_time       time,
    status             varchar,
    created_at         timestamp,
    created_by         bigint,
    updated_at         timestamp,
    updated_by         bigint,
    deleted_at         timestamp,
    deleted_by         bigint,
    transaction_number varchar
);

alter table shopping_cart
    owner to seno;

