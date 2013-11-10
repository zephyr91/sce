quantidade de avaliacao
select count(*),nomeOperadora from AVALIACAO a,OPERADORA o where a.idOperadora = o.idOperadora group by nomeOperadora



-- Media das avaliações de servico que cada operadora possui
select o.nomeOperadora,round(sum(a.media)/count(*),2) from AVALIACAO a, AVALIACAO_SERVICO ap, OPERADORA o where a.idAvaliacao=ap.idAvaliacao and a.idOperadora=o.idOperadora group by nomeOperadora


-- Melhores e piores Produtos e serviços
select max(media),nomeProduto from AVALIACAO a, AVALIACAO_PRODUTO ap, PRODUTO p where a.idAvaliacao=ap.idAvaliacao and p.idProduto=ap.idProduto group by nomeProduto order by media desc limit 0, 1;

select min(media),nomeProduto from AVALIACAO a, AVALIACAO_PRODUTO ap, PRODUTO p where a.idAvaliacao=ap.idAvaliacao and p.idProduto=ap.idProduto group by nomeProduto order by media limit 0, 1;

select max(media),nomeServico from AVALIACAO a, AVALIACAO_SERVICO aser, SERVICO s where a.idAvaliacao=aser.idAvaliacao and s.idServico=aser.idServico group by nomeServico order by media desc limit 0, 1;

select min(media),nomeServico from AVALIACAO a, AVALIACAO_SERVICO aser, SERVICO s where a.idAvaliacao=aser.idAvaliacao and s.idServico=aser.idServico group by nomeServico order by media limit 0, 1;

-- 1) Quantidade de avaliações por região

SELECT COUNT(a.idAvaliacao), u.unidadeFederativa FROM AVALIACAO a, USUARIO u WHERE a.idUsuario = u.idUsuario GROUP BY u.unidadeFederativa; 

-- 2) Média das médias das regiões 

SELECT SUM(a.media)/COUNT(a.media), u.unidadeFederativa FROM AVALIACAO a, USUARIO u WHERE a.idUsuario = u.idUsuario GROUP BY u.unidadeFederativa;

-- 3) Média de idades dos usuários que avaliaram por região

SELECT SUM((SELECT EXTRACT(YEAR FROM current_timestamp)) - (SELECT EXTRACT(YEAR FROM u.dataNascimento)))/COUNT(u.idUsuario) as idade_media, u.unidadeFederativa FROM USUARIO u, AVALIACAO a WHERE a.idUsuario = u.idUsuario GROUP BY u.unidadeFederativa;

-- 4) 10 piores/melhores produtos/serviços avaliados

select max(media),nomeProduto from AVALIACAO a, AVALIACAO_PRODUTO ap, PRODUTO p where a.idAvaliacao=ap.idAvaliacao and p.idProduto=ap.idProduto group by nomeProduto order by media desc limit 0, 10;

select min(media),nomeProduto from AVALIACAO a, AVALIACAO_PRODUTO ap, PRODUTO p where a.idAvaliacao=ap.idAvaliacao and p.idProduto=ap.idProduto group by nomeProduto order by media limit 0, 10;

select max(media),nomeServico from AVALIACAO a, AVALIACAO_SERVICO aser, SERVICO s where a.idAvaliacao=aser.idAvaliacao and s.idServico=aser.idServico group by nomeServico order by media desc limit 0, 10;

select min(media),nomeServico from AVALIACAO a, AVALIACAO_SERVICO aser, SERVICO s where a.idAvaliacao=aser.idAvaliacao and s.idServico=aser.idServico group by nomeServico order by media limit 0, 10;

-- 5) Pergunta que tem a maior/menor média

	-- Média das notas de cada questão onde o produto é = '$idprodutoescolhido'
SELECT SUM(r.nota)/COUNT(r.nota), r.idEstruturaQuestao FROM RESPOSTA r, ESTRUTURA_QUESTAO eq, AVALIACAO_PRODUTO ap, AVALIACAO a WHERE r.idEstruturaQuestao = eq.idEstruturaQuestao AND a.idAvaliacao = ap.idAvaliacao AND a.idAvaliacao = r.idAvaliacao AND ap.idProduto = '$idprodutoescolhido' GROUP BY r.idEstruturaQuestao;

	-- Média das notas de cada questão onde o serviço é = '$idservicoescolhido'

SELECT SUM(r.nota)/COUNT(r.nota), r.idEstruturaQuestao FROM RESPOSTA r, ESTRUTURA_QUESTAO eq, AVALIACAO_SERVICO aser, AVALIACAO a WHERE r.idEstruturaQuestao = eq.idEstruturaQuestao AND a.idAvaliacao = aser.idAvaliacao AND a.idAvaliacao = r.idAvaliacao AND aser.idServico = '$idservicoescolhido' GROUP BY r.idEstruturaQuestao;

	-- Média geral das notas de cada questão de todas avaliações

	SELECT SUM(r.nota)/COUNT(r.nota), r.idEstruturaQuestao FROM RESPOSTA r, ESTRUTURA_QUESTAO eq WHERE r.idEstruturaQuestao = eq.idEstruturaQuestao GROUP BY r.idEstruturaQuestao;

-- 6) Média por sexo

SELECT truncate(SUM(a.media)/COUNT(a.media),2) as media, uc.sexo FROM AVALIACAO a, USUARIO u, CONSUMIDOR uc WHERE a.idUsuario = u.idUsuario AND u.idUsuario = uc.idUsuario GROUP BY uc.sexo;