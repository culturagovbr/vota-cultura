CREATE TABLE public.tb_organizacao_habilitacao_recurso (
	co_organizacao_habilitacao_recurso serial NOT NULL,
	co_organizacao int NOT NULL,
	ds_recurso text NOT NULL,
	dh_cadastro_recurso timestamp NOT NULL DEFAULT now(),
	CONSTRAINT pk_organizacao_habilitacao_recurso PRIMARY KEY (co_organizacao_habilitacao_recurso),
	CONSTRAINT fk_organizacao_habilitacao_recurso FOREIGN KEY (co_organizacao) REFERENCES public.tb_organizacao(co_organizacao)
);

-- Column comments

COMMENT ON COLUMN public.tb_organizacao_habilitacao_recurso.co_organizacao_habilitacao_recurso IS 'Chave primária da tabela';
COMMENT ON COLUMN public.tb_organizacao_habilitacao_recurso.co_organizacao IS 'Chave estrangeira referente a organização';
COMMENT ON COLUMN public.tb_organizacao_habilitacao_recurso.ds_recurso IS 'Descrição do recurso';
COMMENT ON COLUMN public.tb_organizacao_habilitacao_recurso.dh_cadastro_recurso IS 'Data de cadastro do recurso';

--#############
ALTER TABLE public.tb_conselho RENAME COLUMN st_inscricao TO st_indicacao;
ALTER TABLE public.tb_conselho ALTER COLUMN st_indicacao SET DEFAULT 'a';
COMMENT ON COLUMN public.tb_conselho.st_indicacao IS 'situação em que se encontra o período de indicados do conselho. Possíveis opções: a = aberto, f = fechado';
