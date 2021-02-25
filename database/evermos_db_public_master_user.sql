create table master_user
(
    id                  bigserial not null
        constraint master_user_pk
            primary key,
    first_name          varchar,
    last_name           varchar,
    address_id          bigint
        constraint master_user_master_address_id_fk
            references master_address,
    phone_number        varchar(15),
    nik                 char(16),
    email               varchar(50),
    job_id              bigint,
    created_at          timestamp,
    created_by          bigint,
    updated_at          timestamp,
    updated_by          bigint,
    deleted_at          timestamp,
    deleted_by          bigint,
    application_user_id bigint    not null
        constraint master_user_application_user_id_fk
            references application_user,
    is_deleted          integer
);

alter table master_user
    owner to seno;

