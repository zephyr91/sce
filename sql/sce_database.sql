set lc_time_names = 'pt_BR';

create database sce;
use sce;

/* Criação do user core */
create user 'core'@'localhost' identified by password('core');
grant all privileges on sce.* to 'core'@'localhost';

/* Criação do user guest */
create user 'guest'@'localhost';
set password for 'guest'@'localhost' = password('guest');
grant select on sce.* to 'guest'@'localhost';

/* Criação do user admin_sce */
create user 'admin_sce'@'localhost' identified by 'admin_sce';
grant all privileges on sce.* to 'admin_sce'@'localhost' with grant option;