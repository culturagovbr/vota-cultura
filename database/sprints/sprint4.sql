CREATE TABLE public.tb_representante_arquivo_avaliacao
(
    co_representante_arquivo_avaliacao serial PRIMARY KEY NOT NULL,
    co_representante_arquivo int NOT NULL,
    st_em_conformidade char(1) NOT NULL,
    ds_observacao text,
    co_usuario_avaliador int NOT NULL,
    dh_avaliacao timestamp DEFAULT current_timestamp,
    CONSTRAINT tb_representante_arquivo_avaliacao_rl_representante_arquivo_co_representante_arquivo_fk FOREIGN KEY (co_representante_arquivo) REFERENCES public.rl_representante_arquivo (co_representante_arquivo),
    CONSTRAINT tb_representante_arquivo_avaliacao_tb_usuario_co_usuario_fk FOREIGN KEY (co_usuario_avaliador) REFERENCES public.tb_usuario (co_usuario)
);
COMMENT ON COLUMN public.tb_representante_arquivo_avaliacao.st_em_conformidade IS '0 - Não conforme | 1 - Conforme';

CREATE TABLE public.tb_conselho_habilitacao
(
    co_conselho_habilitacao serial PRIMARY KEY NOT NULL,
    co_conselho int NOT NULL,
    st_avaliacao char(1) NOT NULL,
    ds_parecer text,
    CONSTRAINT tb_conselho_habilitacao_tb_conselho_co_conselho_fk FOREIGN KEY (co_conselho) REFERENCES public.tb_conselho (co_conselho)
);
COMMENT ON COLUMN public.tb_conselho_habilitacao.st_avaliacao IS '0 - Habilitado | 1 - Inabilitado';

----- Parte 2

ALTER TABLE public.tb_habilitacao_conselho RENAME TO tb_conselho_habilitacao;
ALTER TABLE public.tb_representante_arquivo_avaliacao ADD co_conselho_habilitacao int NOT NULL;
ALTER TABLE public.tb_representante_arquivo_avaliacao
ADD CONSTRAINT tb_representante_arquivo_avaliacao_tb_conselho_habilitacao_co_conselho_habilitacao_fk
FOREIGN KEY (co_conselho_habilitacao) REFERENCES public.tb_conselho_habilitacao (co_conselho_habilitacao);
