-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 30, 2025 at 03:05 PM
-- Server version: 10.4.32-MariaDB
-- PHP Version: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `portfolio`
--

-- --------------------------------------------------------

--
-- Table structure for table `projects`
--

CREATE TABLE `projects` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `image` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `projects`
--

INSERT INTO `projects` (`id`, `name`, `description`, `image`) VALUES
(1, 'UrbanPulse', 'Uma loja de moda urbana feita para os que vivem no ritmo acelerado da cidade. Design responsivo, catálogo dinâmico e sistema de carrinho funcional. Desenvolvido com foco na experiência do utilizador e performance.', 'uploads/686aa2d55ce0d_buildings-1836478_640.jpg'),
(2, 'GameHype', 'Marketplace moderno para gamers. Catálogo interativo com listagem de lançamentos, plataformas e pré-vendas. Interface envolvente, integração com métodos de pagamento e backend preparado para escalar.', 'uploads/686aa303c73a9_video-games-5412598_640.jpg'),
(3, 'WeBuy', 'Este projeto é um site onde qualquer pessoa pode registar-se para vender ou comprar produtos. Os utilizadores podem criar anúncios com fotos, ver produtos de outros, fazer pesquisas e guardar produtos no carrinho. Tudo é gerido por um painel simples e fácil de usar.', 'uploads/686bc805cf8d7_e-commerce-402822_640.jpg'),
(4, 'LuxCars', 'Aplicação web interna para a empresa LuxCars, especializada em aluguer de veículos de luxo. O sistema permite aos funcionários registar, editar e cancelar reservas, com base de dados MySQL e painel de administração seguro com login.', 'uploads/686bd0dc1720c_aspiration-4927227_640.jpg'),
(5, 'PetMania', 'Desenvolvimento de uma loja virtual simples para a PetMania, com catálogo de produtos, carrinho de compras e simulação de checkout.', '');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(100) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `user_type` enum('user','admin') NOT NULL,
  `profile_pic` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `email`, `password_hash`, `user_type`, `profile_pic`) VALUES
(1, 'JBrito7', 'example123@gmail.com', '$2y$10$3NOnBtLM1G1/zEVgw.HTYu/dLPDORjKtTRMkf2g4Pj5jXFTpcjyDe', 'admin', 'uploads/6873f14cc5396-portrait.jpg'),
(2, 'Matheus123', 'matheus123@hotmail.com', '$2y$10$h4TcKLMsFCUjbhX10t1NJOHWn1SKl.7JUSrkgLxHQOpOHvTtx6qZy', 'user', 'uploads/6873f190c1562-matheus123.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `projects`
--
ALTER TABLE `projects`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `projects`
--
ALTER TABLE `projects`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
