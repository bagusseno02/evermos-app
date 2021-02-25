create table master_supplier
(
    id                            bigserial not null
        constraint master_supplier_pk
            primary key,
    name                          varchar,
    code                          varchar(10),
    address_id                    bigint
        constraint master_supplier_master_address_id_fk
            references master_address,
    phone_number                  varchar(15),
    is_deleted                    boolean default false,
    created_at                    timestamp,
    created_by                    bigint,
    updated_at                    timestamp,
    updated_by                    bigint,
    deleted_at                    timestamp,
    deleted_by                    bigint,
    payment_method_id             bigint
        constraint master_supplier_master_payment_method_id_fk
            references master_payment_method,
    payment_method_account_number varchar(30),
    payment_method_account_name   varchar(50)
);

alter table master_supplier
    owner to seno;

