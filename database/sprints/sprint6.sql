CREATE TABLE public.tb_conselho_indicacao_habilitacao_recurso (
	co_conselho_indicacao_habilitacao_recurso serial NOT NULL,
	co_conselho_indicacao_habilitacao int NOT NULL,
	ds_recurso text NULL,
	st_parecer char(1) NULL,
	co_usuario_avaliador int NOT NULL,
	dh_cadastro_recurso timestamp NOT NULL DEFAULT now(),
	CONSTRAINT pk_tb_conselho_indicacao_habilitacao_recurso PRIMARY KEY (co_conselho_indicacao_habilitacao_recurso),
	CONSTRAINT fk_conselho_indicacao_habilitacao_recurso FOREIGN KEY (co_conselho_indicacao_habilitacao) REFERENCES public.tb_conselho_indicacao_habilitacao(co_conselho_indicacao_habilitacao)
);

-- Column comments

COMMENT ON COLUMN public.tb_conselho_indicacao_habilitacao_recurso.co_conselho_indicacao_habilitacao_recurso IS 'Chave primária da tabela';
COMMENT ON COLUMN public.tb_conselho_indicacao_habilitacao_recurso.co_conselho_indicacao_habilitacao IS 'Código da habilitação do conselho';
COMMENT ON COLUMN public.tb_conselho_indicacao_habilitacao_recurso.ds_recurso IS 'Descrição do recurso.';
COMMENT ON COLUMN public.tb_conselho_indicacao_habilitacao_recurso.st_parecer IS 'Parecer do recurso da habilitação. 0 = Inabilitado, 1 = Habilitado';
COMMENT ON COLUMN public.tb_conselho_indicacao_habilitacao_recurso.co_usuario_avaliador IS 'Código do usuário que realizou a avaliação.';
COMMENT ON COLUMN public.tb_conselho_indicacao_habilitacao_recurso.dh_cadastro_recurso IS 'Data de cadastro do recurso.';


--##############

CREATE TABLE public.tb_conselho_indicacao_habilitacao_recurso_historico (
    co_conselho_indicacao_habilitacao_recurso_historico serial NOT NULL, -- Chave primária da tabela.
    co_conselho_indicacao_habilitacao_recurso int4 NOT NULL, -- Chave estrangeira referente a tabela tb_conselho_indicacao_habilitacao_recurso
    ds_recurso text NULL, -- Descrição do recurso.
    st_parecer bpchar(1) NULL, -- Parecer da avaliação do recurso.
    co_usuario_avaliador int4 NULL, -- Código do usuário que realizou a avaliação do recurso.
    dh_cadastro_recurso timestamp NULL DEFAULT now(), -- Data de cadastro do recurso.
    co_conselho_indicacao_habilitacao int4 NOT NULL,
    CONSTRAINT pk_conselho_indicacao_habilitacao_recurso_historico PRIMARY KEY (co_conselho_indicacao_habilitacao_recurso_historico),
    CONSTRAINT tb_conselho_indicacao_habilitacao_recurso_historico_fk FOREIGN KEY (co_conselho_indicacao_habilitacao_recurso) REFERENCES tb_conselho_indicacao_habilitacao_recurso(co_conselho_indicacao_habilitacao_recurso)
);

-- Column comments

COMMENT ON COLUMN public.tb_conselho_indicacao_habilitacao_recurso_historico.co_conselho_indicacao_habilitacao_recurso_historico IS 'Chave primária da tabela.';
COMMENT ON COLUMN public.tb_conselho_indicacao_habilitacao_recurso_historico.co_conselho_indicacao_habilitacao_recurso IS 'Chave estrangeira referente a tabela tb_conselho_indicacao_habilitacao_recurso';
COMMENT ON COLUMN public.tb_conselho_indicacao_habilitacao_recurso_historico.ds_recurso IS 'Descrição do recurso.';
COMMENT ON COLUMN public.tb_conselho_indicacao_habilitacao_recurso_historico.st_parecer IS 'Parecer da avaliação do recurso.';
COMMENT ON COLUMN public.tb_conselho_indicacao_habilitacao_recurso_historico.co_usuario_avaliador IS 'Código do usuário que realizou a avaliação do recurso.';
COMMENT ON COLUMN public.tb_conselho_indicacao_habilitacao_recurso_historico.dh_cadastro_recurso IS 'Data de cadastro do recurso.';

