SELECT p.codigo, c.nome FROM v2_produtos_de_categoria pc
inner join v2_produto p on p.id=pc.id_produto 
inner join v2_categoria c on c.id = pc.id_categoria
order by p.codigo, c.nome


-- Group categorias into a single row
SELECT p.codigo, group_concat(c.nome separator ', ') 
FROM v2_produtos_de_categoria pc
inner join v2_produto p on p.id=pc.id_produto 
inner join v2_categoria c on c.id = pc.id_categoria
group by p.codigo
order by p.codigo, c.nome
