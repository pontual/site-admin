-- Make categoria.nome and produto.codigo unique
ALTER TABLE v2_categoria ADD CONSTRAINT v2_categoria_nome_uniq UNIQUE (nome);
ALTER TABLE v2_produto ADD CONSTRAINT v2_produto_codigo_uniq UNIQUE (codigo);
