quantidade de avaliacao
select count(*),nomeOperadora from AVALIACAO a,OPERADORA o where a.idOperadora = o.idOperadora group by nomeOperadora



-- Media das avaliações de servico que cada operadora possui
select o.nomeOperadora,round(sum(a.media)/count(*),2) from AVALIACAO a, AVALIACAO_SERVICO ap, OPERADORA o where a.idAvaliacao=ap.idAvaliacao and a.idOperadora=o.idOperadora group by nomeOperadora


-- Melhores e piores Produtos e serviços
select max(media),nomeProduto from AVALIACAO a, AVALIACAO_PRODUTO ap, PRODUTO p where a.idAvaliacao=ap.idAvaliacao and p.idProduto=ap.idProduto group by nomeProduto order by media desc limit 0, 1

select min(media),nomeProduto from AVALIACAO a, AVALIACAO_PRODUTO ap, PRODUTO p where a.idAvaliacao=ap.idAvaliacao and p.idProduto=ap.idProduto group by nomeProduto order by media limit 0, 1

select max(media),nomeServico from AVALIACAO a, AVALIACAO_SERVICO aser, SERVICO s where a.idAvaliacao=aser.idAvaliacao and s.idServico=aser.idServico group by nomeServico order by media desc limit 0, 1

select min(media),nomeServico from AVALIACAO a, AVALIACAO_SERVICO aser, SERVICO s where a.idAvaliacao=aser.idAvaliacao and s.idServico=aser.idServico group by nomeServico order by media limit 0, 1

-- 