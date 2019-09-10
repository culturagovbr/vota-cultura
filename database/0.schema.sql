CREATE TABLE tb_arquivo (
	co_arquivo           SERIAL,
	no_arquivo           varchar(255)  NOT NULL ,
	ds_localizacao       varchar(255)  NOT NULL ,
	dh_insercao          date DEFAULT current_date NOT NULL ,
	no_extensao           varchar(255) ,
	no_mime_type           varchar(50) ,
	CONSTRAINT pk_arquivo_coarquivo PRIMARY KEY ( co_arquivo )
 );


COMMENT ON COLUMN tb_arquivo.no_extensao IS 'Extensão do arquivo';

COMMENT ON COLUMN tb_arquivo.no_mime_type IS 'MIME Type do arquivo';

COMMENT ON COLUMN tb_arquivo.co_arquivo IS 'chave primária da tabela';

COMMENT ON COLUMN tb_arquivo.no_arquivo IS 'nome do arquivo inserido';

COMMENT ON COLUMN tb_arquivo.ds_localizacao IS 'path do arquivo no sistema de arquivos';

COMMENT ON COLUMN tb_arquivo.dh_insercao IS 'data da inserção do arquivo';

CREATE TABLE tb_criterio (
	co_criterio          SERIAL,
	tp_criterio          varchar(100)  NOT NULL ,
	ds_criterio          varchar(150)  NOT NULL ,
	ds_detalhamento      varchar(255)  NOT NULL ,
	qt_pontuacao         integer  NOT NULL ,
	qt_peso              integer  NOT NULL ,
	CONSTRAINT pk_criterio_cocriterio PRIMARY KEY ( co_criterio )
 );

COMMENT ON COLUMN tb_criterio.co_criterio IS 'chave primária da tabela';

COMMENT ON COLUMN tb_criterio.tp_criterio IS 'slug do critério';

COMMENT ON COLUMN tb_criterio.ds_criterio IS 'texto descritivo de qual será o critério';

COMMENT ON COLUMN tb_criterio.ds_detalhamento IS 'texto descritivo de cada opção de acordo com o critério';

COMMENT ON COLUMN tb_criterio.qt_pontuacao IS 'pontuação referente ao detalhamento do critério';

COMMENT ON COLUMN tb_criterio.qt_peso IS 'peso da pontuação';

CREATE TABLE tb_cronograma (
	co_cronograma        SERIAL,
	tp_cronograma        varchar(100)  NOT NULL ,
	dh_inicio            timestamp  NOT NULL ,
	dh_fim               timestamp  NOT NULL ,
	CONSTRAINT pk_tb_cronograma_co_cronograma PRIMARY KEY ( co_cronograma )
 );

COMMENT ON COLUMN tb_cronograma.co_cronograma IS 'chave primária da tabela';

COMMENT ON COLUMN tb_cronograma.tp_cronograma IS 'slug do cronograma agendado';

COMMENT ON COLUMN tb_cronograma.dh_inicio IS 'data de inicío do evento cadastrado';

COMMENT ON COLUMN tb_cronograma.dh_fim IS 'data de fim do evento cadastrado';

CREATE TABLE tb_perfil (
	co_perfil            SERIAL,
	no_perfil            varchar(255)  NOT NULL ,
	ds_perfil            varchar(255)  NOT NULL ,
	st_ativo             bool  NOT NULL ,
	CONSTRAINT pk_perfil_coperfil PRIMARY KEY ( co_perfil )
 );

COMMENT ON COLUMN tb_perfil.co_perfil IS 'chave primária da tabela';

COMMENT ON COLUMN tb_perfil.no_perfil IS 'nome do perfil';

COMMENT ON COLUMN tb_perfil.ds_perfil IS 'descrição do perfil';

COMMENT ON COLUMN tb_perfil.st_ativo IS 'opções:\n\nTrue - Ativo\nFalse - Inativo';

CREATE TABLE tb_representante (
	co_representante     SERIAL,
	ds_email             varchar(255)  NOT NULL ,
	no_pessoa              varchar(100)  NOT NULL ,
	nu_rg                varchar(9)  NOT NULL ,
	nu_cpf               varchar(11)  NOT NULL ,
	nu_telefone          varchar(11)  NOT NULL ,
	CONSTRAINT pk_tb_representante_co_representante PRIMARY KEY ( co_representante ),
	CONSTRAINT uk_01_representante_cpf UNIQUE ( nu_cpf )
 );

COMMENT ON COLUMN tb_representante.co_representante IS 'chave primária da tabela';

COMMENT ON COLUMN tb_representante.ds_email IS 'email do representante';

COMMENT ON COLUMN tb_representante.no_pessoa IS 'nome do representante';

COMMENT ON COLUMN tb_representante.nu_rg IS 'número do RG do representante';

COMMENT ON COLUMN tb_representante.nu_cpf IS 'número de cpf do representante';

CREATE TABLE tb_segmento (
	co_segmento          SERIAL,
	tp_segmento          varchar(100)  NOT NULL ,
	ds_detalhamento      varchar(255)  NOT NULL ,
	st_ativo             bool  NOT NULL ,
	CONSTRAINT pk_segmento_codsegmento PRIMARY KEY ( co_segmento )
 );

COMMENT ON COLUMN tb_segmento.co_segmento IS 'chave primária da tabela';

COMMENT ON COLUMN tb_segmento.tp_segmento IS 'slug do tipo de segmento';

COMMENT ON COLUMN tb_segmento.ds_detalhamento IS 'descrição do tipo de segmento\n(ex: Culturas dos povos indígenas)';

COMMENT ON COLUMN tb_segmento.st_ativo IS 'campo de habilitação/desabilitação do tipo de segmento';

CREATE TABLE tb_tipo_voto (
	co_tipo_voto         SERIAL,
	ds_detalhamento      varchar(100)  NOT NULL ,
	st_ativo             bool  NOT NULL ,
	CONSTRAINT pk_tipovoto_cotipovoto PRIMARY KEY ( co_tipo_voto )
 );

COMMENT ON COLUMN tb_tipo_voto.co_tipo_voto IS 'chave primária da tabela';

COMMENT ON COLUMN tb_tipo_voto.ds_detalhamento IS 'descrição do tipo de voto que foi feito';

COMMENT ON COLUMN tb_tipo_voto.st_ativo IS 'campo de habilitação/desabilitação do tipo de voto';

CREATE TABLE tb_uf (
	co_ibge              integer  NOT NULL ,
	sg_uf                char(2)  NOT NULL ,
	no_uf                varchar(50)  NOT NULL ,
	CONSTRAINT pk_uf_coibge PRIMARY KEY ( co_ibge )
 );

COMMENT ON COLUMN tb_uf.co_ibge IS 'chave primária da tabela';

COMMENT ON COLUMN tb_uf.sg_uf IS 'sigla da unidade federativa';

COMMENT ON COLUMN tb_uf.no_uf IS 'nome da unidade federativa';

CREATE TABLE tb_usuario (
	co_usuario           SERIAL,
	no_nome            varchar(255)  NOT NULL ,
	st_ativo             bool  NOT NULL ,
	ds_email             varchar(50)  NOT NULL ,
	ds_senha             varchar(255)  NOT NULL ,
	dh_cadastro          date  NOT NULL ,
	dh_ultima_atualizacao date  NOT NULL ,
	ds_codigo_ativacao   varchar(255)  NOT NULL ,
	co_perfil            integer   ,
	nu_cpf               varchar(11)  NOT NULL ,
	CONSTRAINT pk_usuario_cousuario PRIMARY KEY ( co_usuario ),
	CONSTRAINT unq_tb_usuario_nu_cpf UNIQUE ( nu_cpf )
 );

COMMENT ON COLUMN tb_usuario.co_usuario IS 'chave primária da tabela';

COMMENT ON COLUMN tb_usuario.no_nome IS 'nome do usuario';

COMMENT ON COLUMN tb_usuario.st_ativo IS 'situação do usuario\n\nTrue = Ativo\nFalse = Inativo';

COMMENT ON COLUMN tb_usuario.ds_email IS 'email do usuario';

COMMENT ON COLUMN tb_usuario.ds_senha IS 'senha do usuario';

COMMENT ON COLUMN tb_usuario.dh_cadastro IS 'data do cadastro do usuario';

COMMENT ON COLUMN tb_usuario.dh_ultima_atualizacao IS 'data da ultima alteração do usuario';

COMMENT ON COLUMN tb_usuario.ds_codigo_ativacao IS 'código para ativação do cadastro do usuario';

COMMENT ON COLUMN tb_usuario.co_perfil IS 'perfil do usuario';

COMMENT ON COLUMN tb_usuario.nu_cpf IS 'número de cpf do representante';

CREATE TABLE tb_versionamento (
	co_versionamento     SERIAL,
	dt_versao            date  NOT NULL ,
	co_versao            char(20)  NOT NULL ,
	ds_alteracao         varchar(400)  NOT NULL ,
	no_modulo            varchar(100)  NOT NULL ,
	CONSTRAINT pk_tb_versionamento_co_versionamento PRIMARY KEY ( co_versionamento )
 );

CREATE TABLE tb_voto (
	co_voto              SERIAL,
	dh_voto              date DEFAULT current_date NOT NULL ,
	co_tipo_voto         integer  NOT NULL ,
	co_usuario           integer  NOT NULL ,
	CONSTRAINT pk_voto_covoto PRIMARY KEY ( co_voto ),
	CONSTRAINT fk_voto_usuario FOREIGN KEY ( co_usuario ) REFERENCES tb_usuario( co_usuario )  ,
	CONSTRAINT fk_voto_tipovoto FOREIGN KEY ( co_tipo_voto ) REFERENCES tb_tipo_voto( co_tipo_voto )
 );

COMMENT ON COLUMN tb_voto.co_voto IS 'chave primária da tabela';

COMMENT ON COLUMN tb_voto.dh_voto IS 'data e hora de quando o voto foi feito';

COMMENT ON COLUMN tb_voto.co_tipo_voto IS 'chave estrangeira para o tipo de votação feita';

COMMENT ON COLUMN tb_voto.co_usuario IS 'chave estrangeira com o usuario que votou';

CREATE TABLE rl_representante_arquivo (
	co_representante_arquivo SERIAL,
	co_representante     integer  NOT NULL ,
	co_arquivo           integer  NOT NULL ,
	tp_arquivo           varchar(100)  NOT NULL ,
	tp_inscricao         char(1)  NOT NULL ,
	CONSTRAINT pk_representante_arquivo_corepresentantearquivo PRIMARY KEY ( co_representante_arquivo ),
	CONSTRAINT fk_representantearquivo_representante FOREIGN KEY ( co_representante ) REFERENCES tb_representante( co_representante )  ,
	CONSTRAINT fk_representantearquivo_arquivo FOREIGN KEY ( co_arquivo ) REFERENCES tb_arquivo( co_arquivo )
 );

CREATE INDEX unq_rl_representante_arquivo_fk_representante ON rl_representante_arquivo ( co_representante );

COMMENT ON COLUMN rl_representante_arquivo.co_representante IS 'chave estrangeira ligando a um representante, que inseriu um arquivo';

COMMENT ON COLUMN rl_representante_arquivo.co_arquivo IS 'chave estrangeira ligando a um arquivo inserido';

COMMENT ON COLUMN rl_representante_arquivo.tp_arquivo IS 'opcoes:\n\ndeclaracao_representante\ndocumento_identificacao\ndocumento_cpf\nato_normativo\nata_reuniao\ndeclaracao_ciencia';

COMMENT ON COLUMN rl_representante_arquivo.tp_inscricao IS '1 - Organização\n2 - Conselho';

CREATE TABLE rl_usuario_perfil (
	co_usuario_perfil    SERIAL,
	co_usuario           integer  NOT NULL ,
	co_perfil            integer  NOT NULL ,
	CONSTRAINT pk_usuarioperfil_cousuarioperfil PRIMARY KEY ( co_usuario_perfil ),
	CONSTRAINT unq_rl_usuario_perfil_co_usuario UNIQUE ( co_usuario ) ,
	CONSTRAINT fk_usuarioperfil_usuario FOREIGN KEY ( co_usuario ) REFERENCES tb_usuario( co_usuario )  ,
	CONSTRAINT fk_usuarioperfil_perfil FOREIGN KEY ( co_perfil ) REFERENCES tb_perfil( co_perfil )
 );

COMMENT ON TABLE rl_usuario_perfil IS 'tabela de relacionamento entre usuario e perfil';

COMMENT ON COLUMN rl_usuario_perfil.co_usuario_perfil IS 'chave primária da tabela';

COMMENT ON COLUMN rl_usuario_perfil.co_usuario IS 'código do usuario';

COMMENT ON COLUMN rl_usuario_perfil.co_perfil IS 'código do perfil';

COMMENT ON CONSTRAINT fk_usuarioperfil_usuario ON rl_usuario_perfil IS 'relacionamento para tabela de usuario';

COMMENT ON CONSTRAINT fk_usuarioperfil_perfil ON rl_usuario_perfil IS 'chave estrangeira para tabela perfil';

CREATE TABLE tb_municipio (
	co_municipio              integer  NOT NULL ,
	no_municipio         varchar(50)  NOT NULL ,
	co_uf                integer  NOT NULL ,
	CONSTRAINT pk_municipio_comunicipio PRIMARY KEY ( co_municipio ),
	CONSTRAINT fk_municipio_uf FOREIGN KEY ( co_uf ) REFERENCES tb_uf( co_ibge )
 );

COMMENT ON COLUMN tb_municipio.co_municipio IS 'chave primaria da tabela, código da base do IBGE';

COMMENT ON COLUMN tb_municipio.no_municipio IS 'nome do município';

COMMENT ON COLUMN tb_municipio.co_uf IS 'chave estrangeira para tabela de uf';

CREATE TABLE tb_endereco (
	co_endereco          SERIAL,
	ds_complemento       varchar(255) ,
	nu_cep               varchar(8)  NOT NULL ,
	ds_logradouro        varchar(255)  NOT NULL ,
	co_municipio         integer  NOT NULL ,
	CONSTRAINT pk_endereco_coendereco PRIMARY KEY ( co_endereco ),
	CONSTRAINT fk_endereco_municipio FOREIGN KEY ( co_municipio ) REFERENCES tb_municipio( co_municipio )
 );

COMMENT ON COLUMN tb_endereco.co_endereco IS 'chave primária da tabela';

COMMENT ON COLUMN tb_endereco.ds_complemento IS 'completo do endereço';

COMMENT ON COLUMN tb_endereco.nu_cep IS 'número do cep';

COMMENT ON COLUMN tb_endereco.ds_logradouro IS 'descrição do logradouro';

COMMENT ON COLUMN tb_endereco.co_municipio IS 'chave estrangeira para tabela que possui dados do ibge';

CREATE TABLE tb_organizacao (
	co_organizacao       SERIAL,
	nu_cnpj              varchar(14)  NOT NULL ,
	no_organizacao       varchar(100)  NOT NULL ,
	ds_email             varchar(100)  NOT NULL ,
	nu_telefone          varchar(11)  NOT NULL ,
	co_segmento          integer  NOT NULL ,
	co_usuario           integer   ,
	co_endereco          integer  NOT NULL ,
	co_representante     integer  NOT NULL ,
	ds_sitio_eletronico  varchar(255)   ,
	st_inscricao         char(1)  NOT NULL ,
	CONSTRAINT pk_organizacao_codorganizacao PRIMARY KEY ( co_organizacao ),
	CONSTRAINT fk_organizacao_segmento FOREIGN KEY ( co_segmento ) REFERENCES tb_segmento( co_segmento )  ,
	CONSTRAINT fk_organizacao_usuario FOREIGN KEY ( co_usuario ) REFERENCES tb_usuario( co_usuario )  ,
	CONSTRAINT fk_organizacao_endereco FOREIGN KEY ( co_endereco ) REFERENCES tb_endereco( co_endereco )  ,
	CONSTRAINT fk_organizacao_representante FOREIGN KEY ( co_representante ) REFERENCES tb_representante( co_representante )
 );

COMMENT ON COLUMN tb_organizacao.co_organizacao IS 'chave primária da tabela';

COMMENT ON COLUMN tb_organizacao.nu_cnpj IS 'CNPJ do Órgão Gestor/Organização';

COMMENT ON COLUMN tb_organizacao.no_organizacao IS 'Nome da organização';

COMMENT ON COLUMN tb_organizacao.ds_email IS 'Email para contato com a organização';

COMMENT ON COLUMN tb_organizacao.nu_telefone IS 'número de telefone para contato com a organização';

COMMENT ON COLUMN tb_organizacao.co_segmento IS 'Chave estrangeira com tabela de dados dos segmento no qual a organização ou entidade cultural pretende concorrer';

COMMENT ON COLUMN tb_organizacao.co_usuario IS 'Chave estrangeira com o usuario que vai gerenciar a organização';

COMMENT ON COLUMN tb_organizacao.co_endereco IS 'Chave estrangeira com os dados do endereço da organização';

COMMENT ON COLUMN tb_organizacao.co_representante IS 'chave estrangeira com os dados do representante legal da organização ou entidade cultural';

COMMENT ON COLUMN tb_organizacao.ds_sitio_eletronico IS 'Descrição do sítio eletrônico da organização ou entidade cultural, caso o mesmo possua';

COMMENT ON COLUMN tb_organizacao.st_inscricao IS 'Situação da inscrição da organização';

CREATE TABLE rl_organizacao_criterio (
	co_organizacao_criterio SERIAL,
	co_criterio          integer  NOT NULL ,
	co_organizacao       integer  NOT NULL ,
	CONSTRAINT orgao_criterio_coorganizacaociterio PRIMARY KEY ( co_organizacao_criterio ),
	CONSTRAINT fk_criterio_organizacao FOREIGN KEY ( co_criterio ) REFERENCES tb_criterio( co_criterio )  ,
	CONSTRAINT fk_organizacao_criterio FOREIGN KEY ( co_organizacao ) REFERENCES tb_organizacao( co_organizacao )
 );

COMMENT ON COLUMN rl_organizacao_criterio.co_organizacao_criterio IS 'chave primária da tabela';

COMMENT ON COLUMN rl_organizacao_criterio.co_criterio IS 'chave estrangeira ligando a um criterio';

COMMENT ON COLUMN rl_organizacao_criterio.co_organizacao IS 'chave estrangeira ligando a uma organização';

CREATE TABLE tb_conselho (
	co_conselho          SERIAL,
	no_orgao_gestor      varchar(150)  NOT NULL ,
	no_conselho          varchar(250) NOT NULL ,
	ds_email             varchar(50)  NOT NULL ,
	nu_telefone          varchar(11)  NOT NULL ,
	nu_cnpj              varchar(14)  NOT NULL ,
	tp_governamental     char(1)  NOT NULL ,
	co_endereco          integer  NOT NULL ,
	co_representante     integer  NOT NULL ,
	co_usuario           integer   ,
	ds_sitio_eletronico  varchar(255)   ,
	st_inscricao         char(1)  NOT NULL ,
	CONSTRAINT pk_conselho_coconselho PRIMARY KEY ( co_conselho ),
	CONSTRAINT fk_conselho_endereco FOREIGN KEY ( co_endereco ) REFERENCES tb_endereco( co_endereco )  ,
	CONSTRAINT fk_conselho_representante FOREIGN KEY ( co_representante ) REFERENCES tb_representante( co_representante )  ,
	CONSTRAINT fk_conselho_usuario FOREIGN KEY ( co_usuario ) REFERENCES tb_usuario( co_usuario )
 );

COMMENT ON COLUMN tb_conselho.co_conselho IS 'chave primária da tabela';

COMMENT ON COLUMN tb_conselho.no_orgao_gestor IS 'nome do Orgão gestor do conselho';

COMMENT ON COLUMN tb_conselho.no_orgao_gestor IS 'Nome do conselho de cultura';

COMMENT ON COLUMN tb_conselho.ds_email IS 'email para contato com o conselho';

COMMENT ON COLUMN tb_conselho.nu_telefone IS 'telefone para contato ao conselho';

COMMENT ON COLUMN tb_conselho.nu_cnpj IS 'CNPJ do Órgão Gestor/Organização';

COMMENT ON COLUMN tb_conselho.tp_governamental IS 'opções:\n(E)stadual\n(C)apital';

COMMENT ON COLUMN tb_conselho.co_endereco IS 'endereço do conselho';

COMMENT ON COLUMN tb_conselho.co_representante IS 'representante principal do conselho';

COMMENT ON COLUMN tb_conselho.co_usuario IS 'chave primária do usuario que terá posse do conselho';

COMMENT ON COLUMN tb_conselho.ds_sitio_eletronico IS 'endereço eletrônico do conselho';

COMMENT ON COLUMN tb_conselho.st_inscricao IS 'situação em que se encontra a inscrição';

CREATE TABLE tb_eleitor (
	co_eleitor           SERIAL,
	nu_cpf               varchar(11)  NOT NULL ,
	no_nome           varchar(255)  NOT NULL ,
	nu_rg                varchar(9)  NOT NULL ,
	dt_nascimento        date  NOT NULL ,
	st_estrangeiro       bool DEFAULT false NOT NULL ,
	co_ibge              integer  NOT NULL ,
	co_usuario           integer ,
	ds_email             varchar(255)  NOT NULL ,
	CONSTRAINT pk_eleitor_codeleitor PRIMARY KEY ( co_eleitor ),
	CONSTRAINT fk_eleitor_tb_uf FOREIGN KEY ( co_ibge ) REFERENCES tb_uf ( co_ibge )  ,
	CONSTRAINT fk_eleitor_usuario FOREIGN KEY ( co_usuario ) REFERENCES tb_usuario( co_usuario )
 );

COMMENT ON COLUMN tb_eleitor.co_eleitor IS 'chave primária da tabela';

COMMENT ON COLUMN tb_eleitor.nu_cpf IS 'número de CPF do eleitor';

COMMENT ON COLUMN tb_eleitor.no_nome IS 'nome do eleitor';

COMMENT ON COLUMN tb_eleitor.nu_rg IS 'numero do RG do eleitor';

COMMENT ON COLUMN tb_eleitor.dt_nascimento IS 'data nascimento do eleitor';

COMMENT ON COLUMN tb_eleitor.st_estrangeiro IS 'Situação se o eleitor é estrangeiro ou não\n\nTrue = É estrangeiro\nFalse = É Brasileiro';

COMMENT ON COLUMN tb_eleitor.co_ibge IS 'chave estrangeira com os dados de UF';

COMMENT ON COLUMN tb_eleitor.co_usuario IS 'chave estrangeira com o usuario para login do inscrito para eleitor';

COMMENT ON COLUMN tb_eleitor.ds_email IS 'email do eleitor';

CREATE TABLE rl_eleitor_arquivo (
	co_eleitor_arquivo SERIAL,
	co_eleitor     integer  NOT NULL ,
	co_arquivo           integer  NOT NULL ,
	tp_arquivo           varchar(100)  NOT NULL ,
	CONSTRAINT pk_eleitor_arquivo_coeleitorarquivo PRIMARY KEY ( co_eleitor_arquivo ),
	CONSTRAINT fk_eleitorarquivo_eleitor FOREIGN KEY ( co_eleitor ) REFERENCES tb_eleitor( co_eleitor )  ,
	CONSTRAINT fk_eleitorarquivo_arquivo FOREIGN KEY ( co_arquivo ) REFERENCES tb_arquivo( co_arquivo )
 );

CREATE INDEX unq_rl_eleitor_arquivo_fk_eleitor ON rl_eleitor_arquivo ( co_eleitor );

COMMENT ON COLUMN rl_eleitor_arquivo.co_eleitor IS 'chave estrangeira ligando a um eleitor, que inseriu um arquivo';

COMMENT ON COLUMN rl_eleitor_arquivo.co_arquivo IS 'chave estrangeira ligando a um arquivo inserido';

COMMENT ON COLUMN rl_eleitor_arquivo.tp_arquivo IS 'opcoes:\n\ndeclaracao_eleitor\ndocumento_identificacao\ndocumento_cpf\nato_normativo\nata_reuniao\ndeclaracao_ciencia';


-- [ Executar abaixo : 10/09/2019] <-------------------------

ALTER TABLE tb_eleitor ADD dh_cadastro timestamp DEFAULT current_timestamp NULL;
ALTER TABLE tb_conselho ADD dh_cadastro timestamp DEFAULT current_timestamp NULL;
ALTER TABLE tb_organizacao ADD dh_cadastro timestamp DEFAULT current_timestamp NULL;
ALTER TABLE tb_representante ADD dh_cadastro timestamp DEFAULT current_timestamp NULL;
ALTER TABLE tb_usuario ALTER COLUMN dh_cadastro TYPE timestamp USING dh_cadastro::timestamp;
ALTER TABLE tb_usuario ALTER COLUMN dh_cadastro SET DEFAULT current_timestamp;
ALTER TABLE tb_usuario ALTER COLUMN dh_ultima_atualizacao TYPE timestamp USING dh_ultima_atualizacao::timestamp;
ALTER TABLE tb_usuario ALTER COLUMN dh_ultima_atualizacao SET DEFAULT current_timestamp;
ALTER TABLE tb_representante rename column no_pessoa to no_nome;
ALTER TABLE tb_usuario ALTER COLUMN ds_codigo_ativacao DROP NOT NULL;
ALTER TABLE tb_eleitor ALTER COLUMN nu_rg TYPE varchar(11) USING nu_rg::varchar(11);
ALTER TABLE tb_usuario
ADD CONSTRAINT fk_usuario_perfil_coperfil
FOREIGN KEY (co_perfil) REFERENCES tb_perfil (co_perfil);

ALTER TABLE tb_cronograma rename TO tb_fase;
ALTER TABLE tb_fase rename COLUMN co_cronograma TO co_fase;
ALTER TABLE tb_fase rename COLUMN tp_cronograma TO tp_fase;
ALTER TABLE tb_fase ADD ds_detalhamento varchar(255) NULL;

---- Recurso Inscrição
create table tb_recurso_inscricao
(
    co_recurso_inscricao serial not null
        constraint tb_recurso_inscricao_pk
            primary key,
    co_fase int not null
        constraint tb_recurso_inscricao_fase_cofasefk
            references tb_fase (co_fase),
    ds_email varchar(100) not null,
    nu_cnpj varchar(14) not null,
    nu_cpf varchar(11) not null,
    nu_telefone varchar(11) not null,
    ds_recurso text not null,
    dh_cadastro timestamp default current_timestamp not null,
    co_usuario_parecer int
        constraint tb_recurso_inscricao_tb_usuario_co_usuario_fk
            references tb_usuario,
    ds_parecer text,
    dh_parecer timestamp,
    st_parecer char(1)
);

comment on table tb_recurso_inscricao is 'Armazena recursos de inscricoes';

comment on column tb_recurso_inscricao.st_parecer is ' 0 - Recusado | 1 - Aceito';


--INSERT INTO tb_fase (co_fase, tp_fase, dh_inicio, dh_fim) VALUES (3, 'abertura_inscricoes_eleitor', '2019-09-15 00:00:01.000000', '2019-09-15 00:00:02.000000');
UPDATE tb_fase SET tp_fase = 'abertura_inscricoes_conselho', dh_inicio = '2019-08-13 10:00:00.000000', dh_fim = '2019-08-30 00:00:00.000000', ds_detalhamento = 'Inscrições - Conselho' WHERE co_fase = 1;
UPDATE tb_fase SET tp_fase = 'abertura_inscricoes_organizacao', dh_inicio = '2019-08-13 10:00:00.000000', dh_fim = '2019-08-30 00:00:00.000000', ds_detalhamento = 'Inscrições - Organização' WHERE co_fase = 2;
UPDATE tb_fase SET tp_fase = 'abertura_inscricoes_eleitor', dh_inicio = '2019-09-15 00:00:01.000000', dh_fim = '2019-09-15 00:00:02.000000', ds_detalhamento = 'Inscrições - Eleitor' WHERE co_fase = 3;
INSERT INTO tb_fase (co_fase, tp_fase, dh_inicio, dh_fim, ds_detalhamento) VALUES (4, 'recurso_inscricoes_conselho', '2019-09-13 00:00:01.000000', '2019-09-08 17:18:21.000000', 'Recurso - Inscrição Conselho');
INSERT INTO tb_fase (co_fase, tp_fase, dh_inicio, dh_fim, ds_detalhamento) VALUES (5, 'recurso_inscricoes_organizacao', '2019-09-13 00:00:01.000000', '2019-09-08 17:18:21.000000', 'Recurso - Inscrição Organização');
