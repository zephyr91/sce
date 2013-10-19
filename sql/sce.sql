set lc_time_names = 'pt_BR';

CREATE TABLE USUARIO
(  idUsuario         INTEGER NOT NULL AUTO_INCREMENT,
  nomeUsuario       VARCHAR (150) NOT NULL ,
  dataNascimento    DATE NOT NULL ,
  email             VARCHAR (100) NOT NULL ,
  senha             CHAR (64) NOT NULL ,
  endereco          VARCHAR (100) NOT NULL ,
  telefonePrincipal CHAR (11) NOT NULL ,
  tipoAcesso        CHAR (1) NOT NULL ,
  telefoneOpcional  CHAR (11) ,
  PRIMARY KEY (idUsuario)
);


CREATE TABLE CONSUMIDOR
(  cpf       CHAR (11) NOT NULL ,
  rg        CHAR (9) NOT NULL ,
  sexo      CHAR (1) NOT NULL ,
  idUsuario INTEGER NOT NULL ,
  FOREIGN KEY ( idUsuario ) REFERENCES USUARIO ( idUsuario ) ON DELETE CASCADE ,
  PRIMARY KEY (idUsuario)
);


CREATE TABLE JURIDICO
(  cnpj      CHAR (14) NOT NULL ,
  idUsuario INTEGER NOT NULL ,
  FOREIGN KEY ( idUsuario ) REFERENCES USUARIO ( idUsuario ) ON DELETE CASCADE ,
  PRIMARY KEY (idUsuario)
);


CREATE TABLE PAGAMENTO
(  idPagamento INTEGER NOT NULL AUTO_INCREMENT,
  valor       DOUBLE PRECISION (10,2) NOT NULL ,
  idUsuario   INTEGER NOT NULL ,
  FOREIGN KEY ( idUsuario ) REFERENCES USUARIO ( idUsuario ) ,
  PRIMARY KEY (idPagamento)
);


CREATE TABLE BOLETO
(  idPagamento       INTEGER NOT NULL ,
  dataGeracaoBoleto DATE NOT NULL ,
  FOREIGN KEY (idPagamento) REFERENCES PAGAMENTO (idPagamento) ON DELETE CASCADE ,
  PRIMARY KEY (idPagamento)
);


CREATE TABLE CARTAO_CREDITO
(  nomeCartaoCredito VARCHAR (50) NOT NULL ,
  operadora         VARCHAR (50) NOT NULL ,
  digitoVerificador CHAR (3) NOT NULL ,
  dataVencimento    DATE NOT NULL ,
  idPagamento       INTEGER NOT NULL ,
  FOREIGN KEY ( idPagamento ) REFERENCES PAGAMENTO ( idPagamento ) ON DELETE CASCADE ,
  PRIMARY KEY (idPagamento)
);


CREATE TABLE PREMIO
(  idPremio   INTEGER NOT NULL AUTO_INCREMENT,
  nomePremio VARCHAR (50) NOT NULL ,
  PRIMARY KEY (idPremio)
);


CREATE TABLE SORTEIO
(  idSorteio             INTEGER NOT NULL AUTO_INCREMENT,
  nomeSorteio           VARCHAR (200) NOT NULL ,
  idPremio              INTEGER NOT NULL ,
  dataInicioInscricao   DATE NOT NULL ,
  dataFimInscricao      DATE NOT NULL ,
  dataRealizacaoSorteio DATE ,
  FOREIGN KEY ( idPremio ) REFERENCES PREMIO ( idPremio ) ,
  PRIMARY KEY (idSorteio)
);


CREATE TABLE USUARIO_SORTEIO
(  dataInscricao DATE NOT NULL ,
  idUsuario     INTEGER NOT NULL ,
  idSorteio     INTEGER NOT NULL ,
  FOREIGN KEY ( idSorteio ) REFERENCES SORTEIO ( idSorteio ) ,
  FOREIGN KEY ( idUsuario ) REFERENCES USUARIO ( idUsuario ) ,
  PRIMARY KEY (idSorteio, idUsuario)
);


CREATE TABLE ESTRUTURA_QUESTAO
(  idEstruturaQuestao INTEGER NOT NULL AUTO_INCREMENT,
  texto TEXT NOT NULL ,
  tipoQuestao CHAR (7) NOT NULL ,
  PRIMARY KEY (idEstruturaQuestao)
);


CREATE TABLE OPERADORA
(  idOperadora       INTEGER NOT NULL AUTO_INCREMENT,
  nomeOperadora     VARCHAR (100) NOT NULL ,
  endereco          VARCHAR (100) ,
  telefonePrincipal CHAR (11) NOT NULL ,
  telefoneOpcional  CHAR (11) ,
  descricaoOperadora VARCHAR(500),
  PRIMARY KEY (idOperadora)
);


CREATE TABLE PRODUTO
(  idProduto   INTEGER NOT NULL AUTO_INCREMENT,
  nomeProduto VARCHAR (100) NOT NULL ,
  idOperadora INTEGER NOT NULL ,
  descricaoProduto VARCHAR (500) ,
  FOREIGN KEY ( idOperadora ) REFERENCES OPERADORA ( idOperadora ) ,
  PRIMARY KEY (idProduto)
);


CREATE TABLE SERVICO
(  idServico   INTEGER NOT NULL AUTO_INCREMENT,
  nomeServico VARCHAR (100) NOT NULL ,
  idOperadora INTEGER NOT NULL ,
  descricaoServico VARCHAR (500) ,
  FOREIGN KEY ( idOperadora ) REFERENCES OPERADORA ( idOperadora ) ,
  PRIMARY KEY (idServico)
);


CREATE TABLE AVALIACAO
(  idAvaliacao INTEGER NOT NULL AUTO_INCREMENT,
  comentario TEXT ,
  cupom       INTEGER ,
  idUsuario   INTEGER NOT NULL ,
  idOperadora INTEGER NOT NULL ,
  FOREIGN KEY (idOperadora) REFERENCES OPERADORA (idOperadora) ,
  FOREIGN KEY (idUsuario) REFERENCES USUARIO (idUsuario) ,
  PRIMARY KEY (idAvaliacao)
);


CREATE TABLE RESPOSTA
(  nota               SMALLINT NOT NULL ,
  idUsuario          INTEGER NOT NULL ,
  idEstruturaQuestao INTEGER NOT NULL ,
  idAvaliacao        INTEGER NOT NULL ,
  FOREIGN KEY ( idAvaliacao ) REFERENCES AVALIACAO ( idAvaliacao ) ,
  FOREIGN KEY ( idEstruturaQuestao ) REFERENCES ESTRUTURA_QUESTAO ( idEstruturaQuestao ) ,
  FOREIGN KEY ( idUsuario ) REFERENCES USUARIO ( idUsuario ) ,
  PRIMARY KEY (idAvaliacao, idEstruturaQuestao, idUsuario)
);


CREATE TABLE AVALIACAO_PRODUTO
(  idAvaliacao INTEGER NOT NULL ,
  idProduto   INTEGER NOT NULL ,
  FOREIGN KEY (idAvaliacao) REFERENCES AVALIACAO (idAvaliacao) ,
  FOREIGN KEY (idProduto) REFERENCES PRODUTO (idProduto) ,
  PRIMARY KEY (idAvaliacao, idProduto)
);


CREATE TABLE AVALIACAO_SERVICO
(  idAvaliacao INTEGER NOT NULL ,
  idServico   INTEGER NOT NULL ,
  FOREIGN KEY (idAvaliacao) REFERENCES AVALIACAO (idAvaliacao) ,
  FOREIGN KEY (idServico) REFERENCES SERVICO (idServico) ,
  PRIMARY KEY (idAvaliacao, idServico)
);

ALTER TABLE AVALIACAO_PRODUTO AUTO_INCREMENT=1;
ALTER TABLE AVALIACAO_SERVICO AUTO_INCREMENT=1;
ALTER TABLE BOLETO AUTO_INCREMENT=1;
ALTER TABLE CARTAO_CREDITO AUTO_INCREMENT=1;
ALTER TABLE CONSUMIDOR AUTO_INCREMENT=1;
ALTER TABLE SERVICO AUTO_INCREMENT=1;
ALTER TABLE USUARIO_SORTEIO AUTO_INCREMENT=1;
ALTER TABLE PAGAMENTO AUTO_INCREMENT=1;
ALTER TABLE PRODUTO AUTO_INCREMENT=1;
ALTER TABLE RESPOSTA AUTO_INCREMENT=1;
ALTER TABLE ESTRUTURA_QUESTAO AUTO_INCREMENT=1;
ALTER TABLE JURIDICO AUTO_INCREMENT=1;
ALTER TABLE SORTEIO AUTO_INCREMENT=1;
ALTER TABLE PREMIO AUTO_INCREMENT=1;
ALTER TABLE AVALIACAO AUTO_INCREMENT=1;
ALTER TABLE USUARIO AUTO_INCREMENT=1;
ALTER TABLE OPERADORA AUTO_INCREMENT=1;
