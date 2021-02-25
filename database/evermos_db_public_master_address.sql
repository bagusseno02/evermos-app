create table master_address
(
    id         bigserial not null
        constraint master_address_pk
            primary key,
    address    varchar,
    post_code  varchar(10),
    village_id bigint,
    is_deleted boolean default false,
    created_at timestamp,
    created_by bigint,
    updated_at timestamp,
    updated_by bigint,
    deleted_at timestamp,
    deleted_by bigint
);

comment on column master_address.village_id is 'get from master_village if used
';

alter table master_address
    owner to seno;

