create table shipping_address
(
    id         bigserial not null
        constraint shipping_address_pk
            primary key,
    user_id    bigint
        constraint shipping_address_master_user_id_fk
            references master_user,
    address    bigint,
    village_id bigint,
    created_at timestamp,
    created_by bigint,
    updated_at timestamp,
    updated_by bigint,
    deleted_at timestamp,
    deleted_by bigint
);

alter table shipping_address
    owner to seno;

