create table shipping
(
    id                  bigserial not null
        constraint shipping_pk
            primary key,
    shipping_address_id bigint    not null
        constraint shipping_shipping_address_id_fk
            references shipping_address,
    logistic_id         bigint    not null
        constraint shipping_master_logistic_id_fk
            references master_logistic,
    shipping_date       date,
    shipping_time       time,
    status              varchar,
    created_at          timestamp,
    created_by          bigint,
    updated_at          timestamp,
    updated_by          bigint,
    deleted_at          timestamp,
    deleted_by          bigint
);

alter table shipping
    owner to seno;

