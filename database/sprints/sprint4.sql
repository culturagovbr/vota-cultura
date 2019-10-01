CREATE TABLE public.tb_organizacao_habilitacao
(
    co_organizacao_habilitacao serial PRIMARY KEY NOT NULL,
    co_organizacao int NOT NULL,
    st_avaliacao char(1) NOT NULL,
    ds_parecer text,
    CONSTRAINT tb_org_hab_tb_org_co_org_fk FOREIGN KEY (co_organizacao) REFERENCES public.tb_organizacao (co_organizacao)
);
COMMENT ON COLUMN public.tb_organizacao_habilitacao.st_avaliacao IS '0 - Habilitado | 1 - Inabilitado';

ALTER TABLE public.tb_representante_arquivo_avaliacao ADD co_organizacao_habilitacao int NOT NULL;

ALTER TABLE public.tb_representante_arquivo_avaliacao
  ADD CONSTRAINT tb_repr_arq_av_cons_hab_co_organizacao_hab_fk
FOREIGN KEY (co_organizacao_habilitacao) REFERENCES public.tb_organizacao_habilitacao (co_organizacao_habilitacao);

ALTER TABLE public.tb_organizacao_habilitacao ADD dh_avaliacao timestamp DEFAULT current_timestamp NOT NULL;

ALTER TABLE public.tb_representante_arquivo_avaliacao DROP co_organizacao_habilitacao;
ALTER TABLE public.tb_organizacao_habilitacao ADD nu_nova_pontuacao int NULL;

--###### Criando a tabela tb_conselho_recurso_habilitacao, vinculada à HU060 ######

CREATE TABLE public.tb_conselho_recurso_habilitacao (
	co_conselho_recurso_habilitacao serial NOT NULL, -- Chave Primária da tabela
	co_conselho int4 NOT NULL, -- Código do conselho a qual o usuário está solicitando recurso
	ds_recurso text NOT NULL, -- Descrição do recurso.
	co_arquivo int4 NULL, -- Referência ao arquivo anexado
	dh_cadastro_recurso timestamp NOT NULL DEFAULT now(), -- Data de cadastro do recurso.
	CONSTRAINT ph_conselho_recurso_habilitacao PRIMARY KEY (co_conselho_recurso_habilitacao),
	CONSTRAINT fk_arquivo_conselho_recurso_habilitacao FOREIGN KEY (co_arquivo) REFERENCES tb_arquivo(co_arquivo),
	CONSTRAINT fk_conselho_conselho_recurso_habilitacao FOREIGN KEY (co_conselho) REFERENCES tb_conselho(co_conselho)
);
CREATE UNIQUE INDEX tb_conselho_recurso_habilitacao_co_conselho_recurso_habilitacao ON public.tb_conselho_recurso_habilitacao USING btree (co_conselho_recurso_habilitacao);

-- Column comments

COMMENT ON COLUMN public.tb_conselho_recurso_habilitacao.co_conselho_recurso_habilitacao IS 'Chave Primária da tabela';
COMMENT ON COLUMN public.tb_conselho_recurso_habilitacao.co_conselho IS 'Código do conselho a qual o usuário está solicitando recurso';
COMMENT ON COLUMN public.tb_conselho_recurso_habilitacao.ds_recurso IS 'Descrição do recurso.';
COMMENT ON COLUMN public.tb_conselho_recurso_habilitacao.co_arquivo IS 'Referência ao arquivo anexado';
COMMENT ON COLUMN public.tb_conselho_recurso_habilitacao.dh_cadastro_recurso IS 'Data de cadastro do recurso.';

-- Permissions

ALTER TABLE public.tb_conselho_recurso_habilitacao OWNER TO votacultura;
GRANT ALL ON TABLE public.tb_conselho_recurso_habilitacao TO votacultura;
