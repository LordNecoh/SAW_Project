-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Creato il: Gen 27, 2025 alle 12:50
-- Versione del server: 10.4.32-MariaDB
-- Versione PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `saw`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `blog_posts`
--

CREATE TABLE `blog_posts` (
  `id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `creator` varchar(255) NOT NULL COMMENT 'Nome del creatore del post'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `blog_posts`
--

INSERT INTO `blog_posts` (`id`, `title`, `content`, `created_at`, `creator`) VALUES
(2, 'First post', '<p>Ehyo <em>everyone</em>!<br><br>This the first post of the<strong> website</strong>, hope you like it :)</p>', '2025-01-26 16:39:28', 'Necoh'),
(3, 'Lorem Ipsum', '<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nullam at urna id elit cursus malesuada. Sed elementum at tortor vitae iaculis. Aenean ac ante sodales nisi tempus auctor. In vel ligula vitae odio lobortis vulputate. Nam eget hendrerit dui. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Nam eget enim nec mi rhoncus blandit non quis nisl. Donec interdum dui magna, semper tincidunt massa ornare eu. Pellentesque aliquet fringilla lectus ut ultricies. Praesent quis velit laoreet, scelerisque felis eget, consequat leo. Curabitur pretium elit sapien, ut pellentesque massa cursus vel. Morbi aliquam et erat sit amet imperdiet. Duis quis fermentum metus. Aenean accumsan, mauris id gravida tempus, nibh mi vulputate purus, non accumsan justo nisl a dolor. Nullam ut sem sit amet nunc viverra rutrum vel ac dui.</p>\r\n<p>Nullam nulla tellus, lobortis a condimentum sit amet, rutrum nec augue. Integer lacinia metus lorem, id ultricies odio tempus at. In maximus bibendum felis, vitae accumsan metus. Quisque venenatis a orci ut fermentum. Quisque ac lectus eros. Mauris aliquet, risus vitae tempor porta, nibh quam varius libero, vitae viverra nunc orci nec sem. Sed maximus orci ligula, sit amet dignissim lacus facilisis et. Proin condimentum dignissim posuere. Duis auctor libero malesuada diam fermentum, et elementum erat posuere. In hac habitasse platea dictumst. Proin in ante sit amet metus condimentum porta iaculis a nulla.</p>', '2025-01-26 21:54:08', 'Necoh'),
(4, 'Third Post', '<p><strong>Ehy!<br><br><br></strong>Sorry for the last post, it might seem weird but, was feeling both latin and poetic.<br>Oh also, we need to do some testing about a new infinite scrolling feature, so expect <em>a bit</em> of blog posts in the next few minutes!</p>', '2025-01-26 21:55:25', 'Necoh'),
(5, 'Costruire una Visione: Il Viaggio Inizia', '<p>Benvenuti nel nostro blog! ???? Qui condividiamo idee, aggiornamenti e ispirazioni legate al nostro progetto. Oggi vogliamo parlare della visione che ci ha guidato fino a questo punto: creare un prodotto che non sia solo funzionale ma anche divertente, unico e appagante per chi lo utilizza.</p>\r\n<p>Raccontaci nei commenti cosa ti ispira di pi&ugrave; nel nostro progetto! ????</p>', '2025-01-26 21:56:13', 'Necoh'),
(6, 'Dietro le Quinte: Come Nasce una Grande Idea', '<p>Hai mai pensato a quanto lavoro c&rsquo;&egrave; dietro le quinte di un progetto creativo?&nbsp; Dal brainstorming iniziale alla realizzazione, ogni passo richiede impegno e determinazione.</p>\r\n<p>Nel nostro team, abbiamo affrontato diverse sfide, ma &egrave; stato tutto parte di un viaggio straordinario. Qual &egrave; stato il tuo momento pi&ugrave; impegnativo in un progetto che hai realizzato? Condividilo con noi!&nbsp;</p>', '2025-01-26 21:56:47', 'Necoh'),
(7, 'Novità in Arrivo: Preparati a Sorprenderti!', '<p>Grandi novit&agrave; in arrivo!&nbsp; Il nostro progetto sta crescendo, e siamo entusiasti di annunciare alcune nuove funzionalit&agrave; che saranno presto disponibili.</p>\r\n<p>Restate sintonizzati per ulteriori dettagli, e nel frattempo lasciateci un commento con ci&ograve; che vi piacerebbe vedere implementato. Le vostre idee sono il nostro motore!&nbsp;</p>', '2025-01-26 21:57:04', 'Necoh'),
(8, 'I Nostri Strumenti Preferiti per Creare', '<p>Ogni progetto ha bisogno di strumenti giusti per crescere.&nbsp; Noi utilizziamo un mix di software e piattaforme per rendere il nostro lavoro il pi&ugrave; fluido possibile.</p>\r\n<p>Un esempio? Utilizziamo [nome di un editor o tecnologia] per migliorare l&rsquo;efficienza e [altro strumento] per gestire il lavoro di squadra. E tu, quali strumenti trovi indispensabili?</p>\r\n<p>&nbsp;</p>', '2025-01-26 21:57:24', 'Necoh'),
(9, 'Dietro il Progetto: Intervista al Team', '<p>Cosa ispira il nostro team? Quali sono le loro storie? ???? In questo post, vi portiamo dietro le quinte con un&rsquo;intervista speciale al cuore del progetto: i nostri sviluppatori, designer e creativi.</p>\r\n<p>Scoprite come siamo passati da un\'idea su carta a un progetto reale.</p>', '2025-01-26 21:57:35', 'Necoh'),
(10, 'Il Futuro è Adesso: Cosa Ci Aspetta?', '<p>Guardiamo al futuro con entusiasmo! ???? Ogni passo che facciamo &egrave; un mattoncino verso un obiettivo pi&ugrave; grande. Nel prossimo periodo ci concentreremo su [esempio di focus: migliorare le prestazioni, aggiungere nuove funzionalit&agrave;, ecc.].</p>\r\n<p>Ci piacerebbe sapere la vostra opinione: dove vedete il nostro progetto tra un anno? Fatecelo sapere nei commenti!</p>', '2025-01-26 21:58:03', 'Necoh'),
(11, 'La Creatività è il Cuore del Nostro Progetto', '<p>La creativit&agrave; &egrave; ci&ograve; che rende ogni progetto unico e straordinario. ???? Ogni decisione che prendiamo, ogni design che creiamo, &egrave; alimentato dalla passione e dall&rsquo;innovazione. Non si tratta solo di tecnologia, ma di dare vita a qualcosa che ispiri e coinvolga.</p>\r\n<p>Qual &egrave; l\'aspetto creativo che ti affascina di pi&ugrave; nel nostro progetto? Condividi i tuoi pensieri nei commenti!</p>', '2025-01-26 22:18:24', 'Necoh'),
(12, 'Come Superiamo le Difficoltà nel Lavoro di Squadra', '<p>Ogni progetto &egrave; una squadra, e ogni squadra deve affrontare le proprie sfide.&nbsp; Come gestiamo i momenti difficili? La chiave &egrave; una comunicazione aperta e la fiducia reciproca. In questo post, esploreremo come affrontiamo i conflitti e miglioriamo il nostro lavoro insieme.</p>\r\n<p>Hai esperienze da condividere su come gestire le difficolt&agrave; in un team? Raccontaci la tua!</p>', '2025-01-26 22:18:35', 'Necoh'),
(13, 'La Tecnologia che Supporta il Nostro Progetto', '<p>La tecnologia &egrave; il nostro alleato pi&ugrave; potente! ???? Nel nostro progetto, facciamo affidamento su [nome della tecnologia o framework] per garantire prestazioni elevate e un\'esperienza utente senza intoppi. Ogni aggiornamento &egrave; pensato per migliorare la stabilit&agrave; e l&rsquo;efficienza.</p>\r\n<p>In questo post, esploreremo come queste tecnologie ci aiutano a raggiungere i nostri obiettivi. Quali strumenti tecnologici utilizzi nel tuo lavoro?</p>', '2025-01-26 22:18:43', 'Necoh'),
(14, 'La Nostra Visione a Lungo Periodo', '<p>Dove ci vediamo tra cinque anni? ???? La nostra visione per il futuro va oltre il presente: non si tratta solo di migliorare ci&ograve; che abbiamo gi&agrave;, ma di innovare, evolvere e anticipare le tendenze. In questo post, condividiamo i nostri obiettivi a lungo termine e cosa speriamo di realizzare.</p>\r\n<p>Ti piacerebbe scoprire un nuovo capitolo di questo progetto in futuro? Cosa vorresti vedere</p>', '2025-01-26 22:18:52', 'Necoh'),
(15, 'Prova emoji', '<p>????</p>', '2025-01-27 11:36:10', 'Necoh'),
(16, 'bacio', '<p>😘</p>', '2025-01-27 11:46:12', 'Necoh'),
(17, 'Secondo Bacio', '<p>😗</p>', '2025-01-27 11:46:33', 'Necoh'),
(18, 'Emoji funzionanti', '<p>&Egrave; ufficiale: da questo momento in poi le emoji funzionano</p>', '2025-01-27 11:46:57', 'Necoh');

-- --------------------------------------------------------

--
-- Struttura della tabella `campaign_info`
--

CREATE TABLE `campaign_info` (
  `name` varchar(30) NOT NULL COMMENT 'Specifies what the field is',
  `amount` float NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci COMMENT='Information about the startup crowdFunding';

--
-- Dump dei dati per la tabella `campaign_info`
--

INSERT INTO `campaign_info` (`name`, `amount`) VALUES
('goal', 3000);

-- --------------------------------------------------------

--
-- Struttura della tabella `donations`
--

CREATE TABLE `donations` (
  `id` int(11) NOT NULL,
  `email` varchar(254) DEFAULT NULL,
  `amount` decimal(10,2) NOT NULL,
  `public` tinyint(1) NOT NULL DEFAULT 0,
  `donation_date` timestamp NOT NULL DEFAULT current_timestamp(),
  `deleted_user` varchar(254) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `donations`
--

INSERT INTO `donations` (`id`, `email`, `amount`, `public`, `donation_date`, `deleted_user`) VALUES
(40, 'leonardo.necordi@gmail.com', 100.00, 1, '2025-01-25 12:04:43', NULL),
(43, 'leonardo.necordi@gmail.com', 20.00, 0, '2025-01-25 12:56:29', NULL),
(44, 'leonardo.necordi@gmail.com', 10.00, 0, '2025-01-25 14:49:54', NULL),
(58, 'mariorossi@gmail.com', 50.00, 1, '2025-01-26 14:14:16', NULL),
(59, 'mariorossi@gmail.com', 30.00, 0, '2025-01-26 14:14:24', NULL);

-- --------------------------------------------------------

--
-- Struttura della tabella `users`
--

CREATE TABLE `users` (
  `email` varchar(254) NOT NULL,
  `firstname` varchar(50) NOT NULL,
  `lastname` varchar(50) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `admin` tinyint(1) NOT NULL DEFAULT 0,
  `password` char(60) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dump dei dati per la tabella `users`
--

INSERT INTO `users` (`email`, `firstname`, `lastname`, `username`, `admin`, `password`) VALUES
('leonardo.necordi@gmail.com', 'Leonardo', 'Necordi', 'Necoh', 1, '$2y$10$XE3XrLcaav6xhwRb4S/rP.Ps8ngc7XIvSG09FBZPpueL2U1Us9NsO'),
('luigimangione@gmail.com', 'Luigi', 'Mangione', 'Luigi', 0, '$2y$10$bNgm1Gm9bvkNJe1xLUL/XOexM6WDx/rHz1mY3hdcC36acLkOU0beO'),
('mariorossi@gmail.com', 'Mario', 'Rossi', 'Mariuz', 0, '$2y$10$mfjcpmrqymWc5IyS53rZLeCEWJQx8GwM8W1CZeQWlHHhL29PjNz/W'),
('puppo@gmail.com', 'Pipit', 'Popiot', 'Popit', 0, '$2y$10$HO.171WVuhzaajfmJAPrfeAYXXW923pefVVcxawom5joE29sIJvBu');

--
-- Indici per le tabelle scaricate
--

--
-- Indici per le tabelle `blog_posts`
--
ALTER TABLE `blog_posts`
  ADD PRIMARY KEY (`id`);

--
-- Indici per le tabelle `campaign_info`
--
ALTER TABLE `campaign_info`
  ADD PRIMARY KEY (`name`);

--
-- Indici per le tabelle `donations`
--
ALTER TABLE `donations`
  ADD PRIMARY KEY (`id`),
  ADD KEY `email` (`email`);

--
-- Indici per le tabelle `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`email`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `email` (`email`);

--
-- AUTO_INCREMENT per le tabelle scaricate
--

--
-- AUTO_INCREMENT per la tabella `blog_posts`
--
ALTER TABLE `blog_posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT per la tabella `donations`
--
ALTER TABLE `donations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- Limiti per le tabelle scaricate
--

--
-- Limiti per la tabella `donations`
--
ALTER TABLE `donations`
  ADD CONSTRAINT `donations_ibfk_1` FOREIGN KEY (`email`) REFERENCES `users` (`email`) ON DELETE SET NULL;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
