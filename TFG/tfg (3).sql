
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


CREATE TABLE `pujas` (
  `id_puja` int(11) NOT NULL,
  `id_subasta` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `cantidad` decimal(10,2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `raffles` (
  `id_raffle` int(11) NOT NULL,
  `id_sneaker` int(11) DEFAULT NULL,
  `precio_ticket` decimal(10,2) DEFAULT NULL,
  `id_ganador` int(11) DEFAULT NULL,
  `estado` enum('Abierto','Cerrado') DEFAULT 'Abierto'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `reseñas` (
  `id_reseña` int(11) NOT NULL,
  `id_venta` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `puntuacion` int(11) DEFAULT NULL CHECK (`puntuacion` between 1 and 5),
  `comentario` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;



CREATE TABLE `sneakers` (
  `id_sneaker` int(11) NOT NULL,
  `id_usuario` int(11) DEFAULT NULL,
  `nombre_sneaker` varchar(100) NOT NULL,
  `marca` varchar(50) DEFAULT NULL,
  `talla` varchar(10) DEFAULT NULL,
  `condicion` enum('Nuevo','Usado') NOT NULL,
  `precio` decimal(10,2) DEFAULT NULL,
  `descripcion` text DEFAULT NULL,
  `imagen_url` blob DEFAULT NULL,
  `estado` enum('Disponible','Vendido') DEFAULT 'Disponible'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


INSERT INTO `sneakers` (`id_sneaker`, `id_usuario`, `nombre_sneaker`, `marca`, `talla`, `condicion`, `precio`, `descripcion`, `imagen_url`, `estado`) VALUES
(1, 1, 'Jordan 4 MILITARY BLUE', 'NIKE', '40', 'Nuevo', 220.00, 'Un estilo retro muy moderno\r\nDescubre el auténtico significado del concepto de comodidad clásica con las Air Jordan 4 Retro. Dotada de algunos de los elementos de diseño más emblemáticos del modelo original, esta nueva reinterpretación de las Jordan resulta tan vanguardista como aquella primera versión lanzada en 1989', NULL, 'Disponible'),
(2, 1, 'ADIDAS WALES BONNER', 'ADIDAS', '44', 'Nuevo', 180.00, 'El Wales Bonner x adidas Samba “Leopard” es una colaboración del diseñador de moda con sede en Londres y adidas en una combinación de colores atrevida y creativa de la zapatilla retro', NULL, 'Disponible'),
(3, 1, 'NEW BALANCE 9060', 'NEW BALANCE', '38', 'Nuevo', 190.00, 'Las New Balance 9060 combinan la esencia clásica con un diseño moderno y atrevido. Inspiradas en la herencia del running de los años 2000, ofrecen una comodidad excepcional gracias a su entresuela ABZORB y la tecnología de amortiguación más avanzada. Perfectas para quienes buscan estilo y confort en cada paso.s', NULL, 'Disponible'),
(4, 1, 'NEW BALANCE 510', 'NEW BALANCE', '40', 'Nuevo', 124.00, 'Las New Balance 510 están diseñadas para aquellos que aman la aventura. Con una construcción robusta y suela All Terrain, estas zapatillas ofrecen tracción y estabilidad en todo tipo de superficies. Comodidad, durabilidad y un diseño versátil hacen de las NB 510 el calzado perfecto para explorar, ya sea en la ciudad o en el campo', NULL, 'Disponible'),
(5, 1, 'NIKE AIR MAX 95', 'NIKE', '42', 'Nuevo', 180.00, 'Las Nike Air Max 95 son un ícono del estilo urbano, inspiradas en la anatomía humana y la naturaleza. Con su diseño ondulado y visible tecnología Air, ofrecen una comodidad y amortiguación insuperables. Su combinación de colores y materiales convierte a las Air Max 95 en un clásico atemporal, perfecto para quienes buscan destacar con un look audaz y auténtico.', NULL, 'Disponible');



CREATE TABLE `sneakers_usuarios` (
  `id_sneaker_usuario` int(11) NOT NULL,
  `id_sneaker` int(11) NOT NULL,
  `id_usuario` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `subastas` (
  `id_subasta` int(11) NOT NULL,
  `id_sneaker` int(11) DEFAULT NULL,
  `precio_inicial` decimal(10,2) DEFAULT NULL,
  `precio_actual` decimal(10,2) DEFAULT NULL,
  `id_ganador` int(11) DEFAULT NULL,
  `estado` enum('Activa','Finalizada') DEFAULT 'Activa'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `ticketsraffle` (
  `id_ticket` int(11) NOT NULL,
  `id_raffle` int(11) DEFAULT NULL,
  `id_usuario` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;


CREATE TABLE `usuarios` (
  `id_usuario` int(11) NOT NULL,
  `nombre` varchar(100) DEFAULT NULL,
  `email` varchar(100) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `fecha_nacimiento` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

INSERT INTO `usuarios` (`id_usuario`, `nombre`, `email`, `contraseña`, `fecha_nacimiento`) VALUES
(1, 'jj', 'juanjo@gamil.com', '1234', '0000-00-00'),
(2, 'juanjose', '1@1', '123', '2001-10-02'),
(3, 'Claudia', '1@12', '$2y$10$EFBnLsifZ8ZBP20GKCJwbOYYOhT3cC8E2rzM/G/9J6tqQcUWbqYlu', '2000-02-12');


CREATE TABLE `ventas` (
  `id_venta` int(11) NOT NULL,
  `id_sneaker` int(11) DEFAULT NULL,
  `id_comprador` int(11) DEFAULT NULL,
  `precio_final` decimal(10,2) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

ALTER TABLE `pujas`
  ADD PRIMARY KEY (`id_puja`),
  ADD KEY `id_subasta` (`id_subasta`),
  ADD KEY `id_usuario` (`id_usuario`);


ALTER TABLE `raffles`
  ADD PRIMARY KEY (`id_raffle`),
  ADD KEY `id_sneaker` (`id_sneaker`),
  ADD KEY `id_ganador` (`id_ganador`);

ALTER TABLE `reseñas`
  ADD PRIMARY KEY (`id_reseña`),
  ADD KEY `id_venta` (`id_venta`),
  ADD KEY `id_usuario` (`id_usuario`);


ALTER TABLE `sneakers`
  ADD PRIMARY KEY (`id_sneaker`),
  ADD KEY `id_usuario` (`id_usuario`);


ALTER TABLE `sneakers_usuarios`
  ADD PRIMARY KEY (`id_sneaker_usuario`),
  ADD KEY `id_sneaker` (`id_sneaker`),
  ADD KEY `id_usuario` (`id_usuario`);


ALTER TABLE `subastas`
  ADD PRIMARY KEY (`id_subasta`),
  ADD KEY `id_sneaker` (`id_sneaker`),
  ADD KEY `id_ganador` (`id_ganador`);


ALTER TABLE `ticketsraffle`
  ADD PRIMARY KEY (`id_ticket`),
  ADD KEY `id_raffle` (`id_raffle`),
  ADD KEY `id_usuario` (`id_usuario`);


ALTER TABLE `usuarios`
  ADD PRIMARY KEY (`id_usuario`),
  ADD UNIQUE KEY `email` (`email`);


ALTER TABLE `ventas`
  ADD PRIMARY KEY (`id_venta`),
  ADD KEY `id_sneaker` (`id_sneaker`),
  ADD KEY `id_comprador` (`id_comprador`);



ALTER TABLE `pujas`
  MODIFY `id_puja` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `raffles`
  MODIFY `id_raffle` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `reseñas`
  MODIFY `id_reseña` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `sneakers`
  MODIFY `id_sneaker` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;


ALTER TABLE `sneakers_usuarios`
  MODIFY `id_sneaker_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;


ALTER TABLE `subastas`
  MODIFY `id_subasta` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `ticketsraffle`
  MODIFY `id_ticket` int(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `usuarios`
  MODIFY `id_usuario` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;


ALTER TABLE `ventas`
  MODIFY `id_venta` int(11) NOT NULL AUTO_INCREMENT;


ALTER TABLE `pujas`
  ADD CONSTRAINT `pujas_ibfk_1` FOREIGN KEY (`id_subasta`) REFERENCES `subastas` (`id_subasta`),
  ADD CONSTRAINT `pujas_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

ALTER TABLE `raffles`
  ADD CONSTRAINT `raffles_ibfk_1` FOREIGN KEY (`id_sneaker`) REFERENCES `sneakers` (`id_sneaker`),
  ADD CONSTRAINT `raffles_ibfk_2` FOREIGN KEY (`id_ganador`) REFERENCES `usuarios` (`id_usuario`);


ALTER TABLE `reseñas`
  ADD CONSTRAINT `reseñas_ibfk_1` FOREIGN KEY (`id_venta`) REFERENCES `ventas` (`id_venta`),
  ADD CONSTRAINT `reseñas_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);


ALTER TABLE `sneakers`
  ADD CONSTRAINT `sneakers_ibfk_1` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

ALTER TABLE `sneakers_usuarios`
  ADD CONSTRAINT `sneakers_usuarios_ibfk_1` FOREIGN KEY (`id_sneaker`) REFERENCES `sneakers` (`id_sneaker`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `sneakers_usuarios_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`) ON DELETE CASCADE ON UPDATE CASCADE;


ALTER TABLE `subastas`
  ADD CONSTRAINT `subastas_ibfk_1` FOREIGN KEY (`id_sneaker`) REFERENCES `sneakers` (`id_sneaker`),
  ADD CONSTRAINT `subastas_ibfk_2` FOREIGN KEY (`id_ganador`) REFERENCES `usuarios` (`id_usuario`);


ALTER TABLE `ticketsraffle`
  ADD CONSTRAINT `ticketsraffle_ibfk_1` FOREIGN KEY (`id_raffle`) REFERENCES `raffles` (`id_raffle`),
  ADD CONSTRAINT `ticketsraffle_ibfk_2` FOREIGN KEY (`id_usuario`) REFERENCES `usuarios` (`id_usuario`);

ALTER TABLE `ventas`
  ADD CONSTRAINT `ventas_ibfk_1` FOREIGN KEY (`id_sneaker`) REFERENCES `sneakers` (`id_sneaker`),
  ADD CONSTRAINT `ventas_ibfk_2` FOREIGN KEY (`id_comprador`) REFERENCES `usuarios` (`id_usuario`);
COMMIT;

