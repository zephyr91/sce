DELIMITER $$

DROP PROCEDURE IF EXISTS insert_rows $$

CREATE PROCEDURE insert_rows (size INT) 
BEGIN
DECLARE
rows INT DEFAULT 0;

WHILE rows < size DO
insert into `USUARIO` values ('',concat('U_',rows),'1980/02/15',concat('U_',rows,'@gmail.com'),'d7ae9de750a5640adf6e724d72643767faa73bca2941781dae9d276ff2d4b4ca','SP','São Paulo','Itaim Bibi','Rua Aluísio nº 1234','11954756612','U','');
SET rows = rows + 1;
END WHILE;
END $$


DELIMITER $$


