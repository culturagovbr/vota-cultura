----- Parte 2

ALTER TABLE public.tb_habilitacao_conselho RENAME TO tb_conselho_habilitacao;
ALTER TABLE public.tb_representante_arquivo_avaliacao ADD co_conselho_habilitacao int NOT NULL;
ALTER TABLE public.tb_representante_arquivo_avaliacao
ADD CONSTRAINT tb_repr_arq_av_cons_hab_co_conselho_hab_fk
FOREIGN KEY (co_conselho_habilitacao) REFERENCES public.tb_conselho_habilitacao (co_conselho_habilitacao);
