create database bd_ventas_ds502;

use bd_ventas_ds502;

create table tb_marca (
	codigo_marca char(5) not null primary key,
    marca varchar(35) not null);

create table tb_categoria (
	codigo_categoria char(5) not null primary key,
    categoria varchar(40) not null);
    

create table tb_producto (
	codigo_producto char(5) not null primary key,
    producto varchar(40) not null,
    costo float,
    ganancia float,
    stock int,
    producto_codigo_marca char(5) not null,
    producto_codigo_categoria char(5) not null,
    foreign key (producto_codigo_marca) references tb_marca (codigo_marca),
    foreign key (producto_codigo_categoria) references tb_categoria (codigo_categoria));
      drop table tb_producto;
      
create table tb_proveedor (
    codigo_proveedor char(5) not null primary key,
    razon_social varchar(80) not null,
    ruc char(11) not null unique,
    direccion varchar(100)
);

-- completar 8 registros
insert into tb_marca values
('M0001', 'Costeño'),
('M0002', 'Samsung'),
('M0003', 'Acer'),
('M0004', 'LG'),
('M0005', 'Apple'),
('M0006', 'Toyota'),
('M0007', 'Nike'),
('M0008', 'Gloria');

select * from tb_marca;

-- completar 8 registros
insert into tb_categoria values
('C0001', 'Abarrotes'),
('C0002', 'Smartphone'),
('C0003', 'Laptop'),
('C0004', 'Leches'),
('C0005', 'Mouse'),
('C0006', 'Teclado'),
('C0007', 'Aceites'),
('C0008', 'Zapatillas');

-- completar 5 registros
insert into tb_producto values
('P0001', 'Arroz 5Kg', 24.52, 0.1625, 145, 'M0001', 'C0001'),
('P0002', 'Laptop Core i3 8GB RAM SSD 256GB', 1050.56, 0.2147, 32, 'M0003', 'C0003'),
('P0003', 'TV Smart 55" 4K', 2199.90, 0.2350, 45, 'M0002', 'C0002'),
('P0004', 'Leche Evaporada Lata 400g', 3.80, 0.1500, 300, 'M0008', 'C0001'),
('P0005', 'Monitor Gamer 24"', 750.00, 0.2000, 18, 'M0003', 'C0003');

select * from tb_producto;

insert into tb_proveedor (codigo_proveedor, razon_social, ruc, direccion) values
('P0001', 'Tecnología y Soluciones S.A.C.', '20501234567', 'Av. Arequipa 123, Miraflores'),
('P0002', 'Distribuidora del Norte E.I.R.L.', '20109876543', 'Calle Los Pinos 456, Trujillo'),
('P0003', 'Comercializadora Textil Andina S.A.', '20601122334', 'Jr. Gamarra 789, La Victoria'),
('P0004', 'Importaciones Digitales Perú S.R.L.', '20554433221', 'Av. El Sol 987, Cusco'),
('P0005', 'Servicios Generales Omega S.A.C.', '20401231234', NULL);

-- Listar Marca
delimiter ##
create procedure sp_listar_marca()
begin
	select * from tb_marca order by marca asc;
end; ##
call sp_listar_marca();

-- Listar Categoría
delimiter ##
create procedure sp_listar_categoria()
begin
	select * from tb_categoria order by categoria asc;
end; ##

call sp_listar_categoria();

-- Listar Producto
delimiter ##
create procedure sp_listar_producto()
begin
	select * from tb_producto order by stock desc;
end; ##

call sp_listar_producto();

-- SP Buscar un producto por código.
DELIMITER ##
CREATE PROCEDURE sp_buscar_producto_por_codigo(IN cod_prod CHAR(5))
BEGIN
	SELECT 
		p.codigo_producto,
		p.producto,
        p.costo,
        ROUND(p.ganancia * 100, 2) AS ganancia,
        ROUND(p.costo + (p.costo * p.ganancia), 2) AS precio,
        p.stock,
        ROUND((p.costo + (p.costo * p.ganancia)) * p.stock, 2) AS total,
        c.categoria,
        m.marca AS presentacion_marca
	FROM tb_producto p
	INNER JOIN tb_categoria c ON p.producto_codigo_categoria = c.codigo_categoria
	INNER JOIN tb_marca m ON p.producto_codigo_marca = m.codigo_marca
	WHERE p.codigo_producto = cod_prod;
END; ##

DELIMITER ;

call sp_buscar_producto_por_codigo('P0004');

-- SP Registrar Producto
DELIMITER ##
CREATE PROCEDURE sp_registrar_producto(
    IN cod_prod CHAR(5),
    IN prod VARCHAR(40),
    IN stk INT,
    IN cst FLOAT,
    IN gnc FLOAT,
    IN cod_mar CHAR(5),
    IN cod_cat CHAR(5)
)
BEGIN 
    INSERT INTO tb_producto
    VALUES (cod_prod, prod, stk, cst, gnc, cod_mar, cod_cat);
END##
DELIMITER ;


call sp_registrar_producto('P0010', 'Teclado Magnetico', 72, 460.99, 0.20,'M0004','C0006');
select * from tb_producto;
SHOW CREATE PROCEDURE sp_registrar_producto;


-- SP Editar Producto
delimiter ##
create procedure sp_editar_producto(
	in cod_prod char(5), in prod varchar(40), in stk int,
	in cst float, gnc float, cod_mar char(5), cod_cat char(5))
begin
	update tb_producto set producto = prod, stock = stk, costo = cst, ganancia = gnc,
							producto_codigo_marca = cod_mar, producto_codigo_categoria = cod_cat
	where codigo_producto = cod_prod;
end; ##

call sp_editar_producto('P0006', 'Teclado Mecanico RGB', 72, 360.99, 0.20,'M0004','C0006');

-- SP Borrar un Producto
delimiter ##
create procedure sp_borrar_producto(in cod_prod char(5))
begin 
	delete from tb_producto
    where codigo_producto = cod_prod;
end; ##

call sp_borrar_producto('P0003');
