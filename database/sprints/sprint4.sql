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

CREATE TABLE public.tb_habilitacao_conselho
(
    co_habilitacao_conselho serial PRIMARY KEY NOT NULL,
    co_conselho int NOT NULL,
    st_avaliacao char(1) NOT NULL,
    ds_parecer text,
    CONSTRAINT tb_habilitacao_conselho_tb_conselho_co_conselho_fk FOREIGN KEY (co_conselho) REFERENCES public.tb_conselho (co_conselho)
);
COMMENT ON COLUMN public.tb_habilitacao_conselho.st_avaliacao IS '0 - Habilitado | 1 - Inabilitado';
