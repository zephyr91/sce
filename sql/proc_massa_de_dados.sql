DELIMITER $$

	DROP PROCEDURE IF EXISTS insert_rows $$

	CREATE PROCEDURE insert_rows (size INT) 
		BEGIN
		
		DECLARE rows INT DEFAULT 0;
		
		WHILE rows < size DO
			
			insert into `USUARIO` values ('',concat('U_',rows),'1980/02/15',concat('U_',rows,'@gmail.com'),'d7ae9de750a5640adf6e724d72643767faa73bca2941781dae9d276ff2d4b4ca','SP','São Paulo','Itaim Bibi','Rua Aluísio nº 1234','11954756612','U','');
			
			SET rows = rows + 1;

		END WHILE;
	END $$


DELIMITER $$


DELIMITER $$

DROP PROCEDURE IF EXISTS avaliacao_rows $$

CREATE PROCEDURE avaliacao_rows (size INT) 
	BEGIN
	
	DECLARE
		rows INT DEFAULT 20;
		opselected INT;
		op1 INT DEFAULT 1;
		op2 INT DEFAULT 4;
		nota INT;
		nota_i int DEFAULT 0;
		idserv int;


	WHILE rows < size DO

		SELECT mod(round(RAND() *10), 2)+1  into opselected from dual;

		IF opselected=1 THEN
			set idserv=8;
		ELSEIF opselected=2 THEN
			set idserv=11;
		END IF;

		insert into AVALIACAO values ('','',1,rows,opselected,'S');
		insert into AVALIACAO_SERVICO values ((select a.idAvaliacao from AVALIACAO a, SERVICO s where a.idUsuario=rows and a.idOperadora=opselected and s.idServico=idserv order by a.idAvaliacao desc limit 0, 1),idserv);
		
		notas_loop: LOOP

			IF nota_i=5 THEN

				leave notas_loop;

			END IF;

			select truncate( RAND() , 1 ) into nota from dual;

			CASE nota
				WHEN 0.0 THEN SET nota = 1;
				WHEN 0.1 THEN SET nota = 1;
				WHEN 0.2 THEN SET nota = 2;
				WHEN 0.3 THEN SET nota = 2;
				WHEN 0.4 THEN SET nota = 3;
				WHEN 0.5 THEN SET nota = 3;
				WHEN 0.6 THEN SET nota = 4;
				WHEN 0.7 THEN SET nota = 4;
				WHEN 0.8 THEN SET nota = 5;
				WHEN 0.9 THEN SET nota = 5;
			END CASE;

			set nota_i = nota_i+1;

		END LOOP simple_loop;

	SET rows = rows + 1;
	END WHILE;
	END $$


DELIMITER $$
