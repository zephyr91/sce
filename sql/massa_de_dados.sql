set lc_time_names = 'pt_BR';

insert into PREMIO values ('','Playstation 3');
insert into PREMIO values ('','Playstation 2');
insert into PREMIO values ('','Playstation 1');
insert into PREMIO values ('','Xbox 1');
insert into PREMIO values ('','Xbox 2');
insert into PREMIO values ('','Xbox 360');
insert into PREMIO values ('','Nintendo Wii');
insert into PREMIO values ('','Nintendo 64');
insert into PREMIO values ('','Gameboy');
insert into PREMIO values ('','Super Nintendo');
insert into PREMIO values ('','Mega Drive');
insert into PREMIO values ('','DreamCast');


insert into OPERADORA values ('','VIVO','','11324783429','');
insert into OPERADORA values ('','CLARO','','11324787812','');
insert into OPERADORA values ('','TIM','','11324781234','');
insert into OPERADORA values ('','GVT','','11324780987','');
insert into OPERADORA values ('','TELEFONICA','','11324716563','');
insert into OPERADORA values ('','NEXTEL','','11324701928','');
insert into OPERADORA values ('','OI','','11324701928','');

insert into SORTEIO values  ('','Sorteio do GUGU','1',current_timestamp - INTERVAL 60 DAY,current_timestamp - INTERVAL 30 DAY,'');
insert into SORTEIO values  ('','Sorteio do LULU','2',current_timestamp,current_timestamp + INTERVAL 6 DAY,'');
insert into SORTEIO values  ('','Sorteio do Semana','3',current_timestamp,current_timestamp  + INTERVAL 90 DAY,'');
insert into SORTEIO values  ('','Mega Sorteio do Mes','4',current_timestamp,current_timestamp  + INTERVAL 1 DAY,'');
insert into SORTEIO values  ('','Black Friday','1',current_timestamp,current_timestamp  + INTERVAL 6 WEEK,'');
insert into SORTEIO values  ('','Semana da Baboseira','2',current_timestamp,current_timestamp  + INTERVAL 10 DAY,'');
insert into SORTEIO values  ('','Sorteio da Felicidade','1',current_timestamp - INTERVAL 12 WEEK,current_timestamp - INTERVAL 10 WEEK,'');
insert into SORTEIO values  ('','Sorteio da Sorte','11',current_timestamp,current_timestamp + INTERVAL 100 DAY,'');
insert into SORTEIO values  ('','Sorteio da Sorte2','12',current_timestamp,current_timestamp + INTERVAL 100 DAY,'');
insert into SORTEIO values  ('','Sorteio da Sorte3','10',current_timestamp,current_timestamp + INTERVAL 100 DAY,'');
insert into SORTEIO values  ('','Sorteio da Sorte4','5',current_timestamp,current_timestamp + INTERVAL 100 DAY,'');
insert into SORTEIO values  ('','Sorteio da Sorte5','10',current_timestamp,current_timestamp + INTERVAL 100 DAY,'');
insert into SORTEIO values  ('','Sorteio da Sorte600','9',current_timestamp,current_timestamp + INTERVAL 100 DAY,'');
insert into SORTEIO values  ('','Sorteio da Sorte Grande','8',current_timestamp,current_timestamp + INTERVAL 100 DAY,'');
insert into SORTEIO values  ('','Sorteio da Sorte Maluca','7',current_timestamp,current_timestamp + INTERVAL 100 DAY,'');
insert into SORTEIO values  ('','Sorteio da Sorte Boa','5',current_timestamp,current_timestamp + INTERVAL 100 DAY,'');


insert into USUARIO values ('','David Henrique Langbajn','1991/01/21','david@sce.com.br','07d046d5fac12b3f82daf5035b9aae86db5adc8275ebfbf05ec83005a4a8ba3e','Rua Chora Menino 298','11998216420','A','');
insert into USUARIO values ('','Marcus Vinicius Caldeira Olivares','1990/11/23','marcus@sce.com.br','d7ae9de750a5640adf6e724d72643767faa73bca2941781dae9d276ff2d4b4ca','Rua Copacabana','11967070617','A','');
insert into USUARIO values ('','Camila Alves Sousa','1980/02/15','camila@gmail.com','d7ae9de750a5640adf6e724d72643767faa73bca2941781dae9d276ff2d4b4ca','Rua Aluísio nº 574','11954756612','U','');
insert into USUARIO values ('','João Pedro Ferreira','1976/04/02','joao@uol.com.br','d7ae9de750a5640adf6e724d72643767faa73bca2941781dae9d276ff2d4b4ca','Rua Frei João nº 154','11947852114','U','');
insert into USUARIO values ('','Thiago Maurício dos Santos','19821/06/27','thi221@hotmail.com','d7ae9de750a5640adf6e724d72643767faa73bca2941781dae9d276ff2d4b4ca','Rua Conde de Barão nº 112 AP 48','11992456887','U','');
insert into USUARIO values ('','Telefonica do Brasil','1968/04/10','jonas@telefonica.com.br','d7ae9de750a5640adf6e724d72643767faa73bca2941781dae9d276ff2d4b4ca','Rua Aluísio nº 574','11954756612','U','');
insert into USUARIO values ('','OI Operadora do Brasil','2000/05/10','mario@oi.com.br','d7ae9de750a5640adf6e724d72643767faa73bca2941781dae9d276ff2d4b4ca','Rua Frei João nº 154','11947852114','U','');
insert into USUARIO values ('','CLARO Operadora do Brasil','1970/09/10','claro@claro.com.br','d7ae9de750a5640adf6e724d72643767faa73bca2941781dae9d276ff2d4b4ca','Rua Conde de Barão nº 112 AP 48','11992456887','U','');


/*-- Os IDs são apenas para os usuários existentes*/
insert into CONSUMIDOR values ('11111111111','483792831','M',1);
insert into CONSUMIDOR values ('55555555555','483792831','M',2);
insert into CONSUMIDOR values ('44444444444','483792831','F',3);
insert into CONSUMIDOR values ('33333333333','483792831','M',4);
insert into CONSUMIDOR values ('22222222222','483792831','M',5);


/*-- Os IDs são apenas para os usuários existentes*/
insert into JURIDICO values ('11111111111111',6);
insert into JURIDICO values ('22222222222222',7);
insert into JURIDICO values ('44214516641000',8);



/*-- Devemos adicionar mais uns dias ou semanas no current_timestamp */
insert into USUARIO_SORTEIO values (current_timestamp,1,11);
insert into USUARIO_SORTEIO values (current_timestamp,1,5);
insert into USUARIO_SORTEIO values (current_timestamp,5,11);
insert into USUARIO_SORTEIO values (current_timestamp,2,11);
insert into USUARIO_SORTEIO values (current_timestamp,4,11);
insert into USUARIO_SORTEIO values (current_timestamp,3,3);
insert into USUARIO_SORTEIO values (current_timestamp,2,4);
insert into USUARIO_SORTEIO values (current_timestamp,6,7);
insert into USUARIO_SORTEIO values (current_timestamp,5,9);
insert into USUARIO_SORTEIO values (current_timestamp,4,9);
insert into USUARIO_SORTEIO values (current_timestamp,3,9);
insert into USUARIO_SORTEIO values (current_timestamp,2,9);



/* Os Ids são apenas para as operadoras existentes */
insert into SERVICO values ('','Serviço Movel Pessoal',1);
insert into SERVICO values ('','Serviço Movel Pessoal',2);
insert into SERVICO values ('','Serviço Movel Pessoal',3);
insert into SERVICO values ('','Serviço Movel Pessoal',4);
insert into SERVICO values ('','Serviço Movel Pessoal',5);
insert into SERVICO values ('','Serviço Movel Pessoal',6);
insert into SERVICO values ('','Serviço Movel Pessoal',7);
insert into SERVICO values ('','Internet',1);
insert into SERVICO values ('','Internet',2);
insert into SERVICO values ('','Internet',3);
insert into SERVICO values ('','Internet',4);
insert into SERVICO values ('','Internet',5);
insert into SERVICO values ('','Internet',6);
insert into SERVICO values ('','Internet',7);

/* VIVO */
insert into PRODUTO values ('','Celular Motorola',1);
insert into PRODUTO values ('','Modem de Internet 3G',1);
insert into PRODUTO values ('','Modem de Internet 4G',1);
insert into PRODUTO values ('','Celular Samsung',1);
insert into PRODUTO values ('','Celular Nokia',1);
insert into PRODUTO values ('','Smartphone Motorola',1);
insert into PRODUTO values ('','Smartphone Samsung',1);
insert into PRODUTO values ('','Smartphone Apple',1);
insert into PRODUTO values ('','Smartphone Nextel',1);
insert into PRODUTO values ('','Tablet Samsung',1);
insert into PRODUTO values ('','Tablet Motorola',1);
insert into PRODUTO values ('','Tablet Apple',1);
insert into PRODUTO values ('','Modem de Internet',1);
insert into PRODUTO values ('','Modem com WIFI',1);
/* CLARO */
insert into PRODUTO values ('','Celular Motorola',2);
insert into PRODUTO values ('','Modem de Internet 3G',2);
insert into PRODUTO values ('','Modem de Internet 4G',2);
insert into PRODUTO values ('','Celular Samsung',2);
insert into PRODUTO values ('','Celular Nokia',2);
insert into PRODUTO values ('','Smartphone Motorola',2);
insert into PRODUTO values ('','Smartphone Samsung',2);
insert into PRODUTO values ('','Smartphone Apple',2);
insert into PRODUTO values ('','Smartphone Nextel',2);
insert into PRODUTO values ('','Tablet Samsung',2);
insert into PRODUTO values ('','Tablet Motorola',2);
insert into PRODUTO values ('','Tablet Apple',2);
insert into PRODUTO values ('','Modem de Internet',2);
insert into PRODUTO values ('','Modem com WIFI',2);
/* TIM */
insert into PRODUTO values ('','Celular Motorola',3);
insert into PRODUTO values ('','Modem de Internet 3G',3);
insert into PRODUTO values ('','Modem de Internet 4G',3);
insert into PRODUTO values ('','Celular Samsung',3);
insert into PRODUTO values ('','Celular Nokia',3);
insert into PRODUTO values ('','Smartphone Motorola',3);
insert into PRODUTO values ('','Smartphone Samsung',3);
insert into PRODUTO values ('','Smartphone Apple',3);
insert into PRODUTO values ('','Smartphone Nextel',3);
insert into PRODUTO values ('','Tablet Samsung',3);
insert into PRODUTO values ('','Tablet Motorola',3);
insert into PRODUTO values ('','Tablet Apple',3);
insert into PRODUTO values ('','Modem de Internet',3);
insert into PRODUTO values ('','Modem com WIFI',3);

insert into PAGAMENTO values ('',500.50,'6');
insert into PAGAMENTO values ('',200.00,'7');

insert into BOLETO values ('1',current_timestamp - INTERVAL 3 DAY);

insert into CARTAO_CREDITO values ('Telefonica','Master Card','509','2015/08/10','2');


insert into ESTRUTURA_QUESTAO values ('','Qualidade de serviço ?');
insert into ESTRUTURA_QUESTAO values ('','Qualidade do sinal ?');
insert into ESTRUTURA_QUESTAO values ('','Qualidade do produto ?');
insert into ESTRUTURA_QUESTAO values ('','Custo e benefício do produto?');
insert into ESTRUTURA_QUESTAO values ('','Qualidade de atendimento ?');

insert into ESTRUTURA_QUESTAO values ('','Este produto atende às suas expectativas quanto a sua funcionalidade?','PRODUTO');
insert into ESTRUTURA_QUESTAO values ('','Este produto atende às suas expectativas quanto a seu desempenho técnico?','PRODUTO');
insert into ESTRUTURA_QUESTAO values ('','Qual seu índice de satisfação relacionado à facilidade de uso deste produto?','PRODUTO');
insert into ESTRUTURA_QUESTAO values ('','Qual seu índice de satisfação relacionado ao custo-benefício deste produto?','PRODUTO');
insert into ESTRUTURA_QUESTAO values ('','Você recomendaria este produto para alguém?','PRODUTO');
insert into ESTRUTURA_QUESTAO values ('','Este serviço atende às suas expectativas quanto a sua funcionalidade?','SERVICO');
insert into ESTRUTURA_QUESTAO values ('','Este serviço atende às suas expectativas quanto a seu desempenho?','SERVICO');
insert into ESTRUTURA_QUESTAO values ('','Qual seu índice de satisfação relacionado ao custo-benefício deste serviço?','SERVICO');
insert into ESTRUTURA_QUESTAO values ('','A disponibilidade deste serviço é estável?','SERVICO');
insert into ESTRUTURA_QUESTAO values ('','Você recomendaria este serviço para alguém?','SERVICO');