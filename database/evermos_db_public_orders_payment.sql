create table orders_payment
(
    id                     bigserial not null
        constraint orders_payment_ok
            primary key,
    payment_method_id      bigint    not null
        constraint orders_payment_master_payment_method_id_fk
            references master_payment_method,
    payment_account_number varchar(50),
    payment_status         varchar(30),
    payment_date           date,
    payment_time           time,
    created_at             timestamp,
    created_by             bigint,
    updated_at             timestamp,
    updated_by             bigint,
    deleted_at             timestamp,
    deleted_by             bigint,
    order_id               bigint    not null
        constraint orders_payment_orders_id_fk
            references orders
);

alter table orders_payment
    owner to seno;

