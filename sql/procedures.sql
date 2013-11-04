DELIMITER $$

	DROP PROCEDURE IF EXISTS insert_rows $$

	CREATE PROCEDURE insert_rows (size INT) 
		BEGIN
		
		DECLARE rows INT DEFAULT 1;
		
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
	
		/*numuser INT DEFAULT 20; é necessário verificar quantos usuários existem no banco. numuser deve ser o próximo usuário após o último*/
		DECLARE numuser INT DEFAULT 0;
		DECLARE opselected INT;
		DECLARE op1 INT DEFAULT 1;
		DECLARE op2 INT DEFAULT 4;
		DECLARE idop INT;
		DECLARE nota INT;
		DECLARE nota_aux DOUBLE PRECISION;
		DECLARE nota_i INT DEFAULT 0;
		DECLARE questao_i INT DEFAULT 6;
		DECLARE	idserv INT;
		DECLARE media_c INT;
		DECLARE media_final DOUBLE PRECISION (2,1);
		DECLARE last_avaliacao INT;

		SELECT COUNT(*) into numuser from USUARIO where nomeUsuario not like 'U_%';
	/* numuser começa no default especificado acima. size precisa ser o numero final de users + 1 (olhar a quantidade de users total do banco)*/
		set size = size+numuser;
		
	WHILE numuser < size DO

		SELECT mod(round(RAND() *10), 2)+1  into opselected from dual;

		IF opselected=1 THEN
			set idserv=8;
			set idop=1;
			set media_c=0;
		ELSEIF opselected=2 THEN
			set idserv=11;
			set idop=4;
			set media_c=0;
		END IF;

		insert into AVALIACAO values ('','',1,numuser,idop,'S',0);
		select a.idAvaliacao into last_avaliacao from AVALIACAO a, SERVICO s where a.idUsuario=numuser and a.idOperadora=idop and s.idServico=idserv order by a.idAvaliacao desc limit 0, 1;
		insert into AVALIACAO_SERVICO values ((select a.idAvaliacao from AVALIACAO a, SERVICO s where a.idUsuario=numuser and a.idOperadora=idop and s.idServico=idserv order by a.idAvaliacao desc limit 0, 1),idserv);
		
		IF questao_i = 11 THEN
			set questao_i = 6;
		END IF;
		
		set nota_i=0;
		
		notas_loop: LOOP

			IF nota_i=5 THEN

				leave notas_loop;

			END IF;

			select truncate( RAND() , 1 ) into nota_aux from dual;

			CASE nota_aux
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

			/*insert into RESPOSTA values ('',nota,numuser,questao_i,(select idAvaliacao from AVALIACAO where idUsuario=numuser order by idAvaliacao desc limit 0, 1));*/
			insert into RESPOSTA values ('',nota,numuser,questao_i,(select a.idAvaliacao from AVALIACAO a, SERVICO s where a.idUsuario=numuser and a.idOperadora=idop and s.idServico=idserv order by a.idAvaliacao desc limit 0, 1));
			
			set nota_i = nota_i+1;
			set questao_i = questao_i+1;
			set media_c = media_c + nota;

		END LOOP notas_loop;

		set media_final=media_c/5;

		update AVALIACAO set media=media_final where idAvaliacao=last_avaliacao;

	SET numuser = numuser + 1;
	END WHILE;
	END $$


DELIMITER $$
