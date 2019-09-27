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
