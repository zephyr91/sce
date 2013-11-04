quantidade de avaliacao
select count(*),nomeOperadora from AVALIACAO a,OPERADORA o where a.idOperadora = o.idOperadora group by nomeOperadora



-- Media das avaliações de servico que cada operadora possui
select o.nomeOperadora,round(sum(a.media)/count(*),2) from AVALIACAO a, AVALIACAO_SERVICO ap, OPERADORA o where a.idAvaliacao=ap.idAvaliacao and a.idOperadora=o.idOperadora group by nomeOperadora