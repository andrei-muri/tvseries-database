-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Gazdă: 127.0.0.1
-- Timp de generare: ian. 16, 2024 la 06:21 PM
-- Versiune server: 10.4.32-MariaDB
-- Versiune PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Bază de date: `tvseries2`
--

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `actors`
--

CREATE TABLE `actors` (
  `actor_id` int(11) NOT NULL,
  `actor_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `actors`
--

INSERT INTO `actors` (`actor_id`, `actor_name`) VALUES
(1, 'Gabriel Macht'),
(2, 'Patrick Adams'),
(3, 'Emilia Clarke'),
(4, 'Peter Dinklage'),
(5, 'Bryan Cranston'),
(6, 'Aaron Paul'),
(7, 'Cillian Murphy'),
(8, 'Paul Anderson'),
(9, 'Travis Fimmel'),
(10, 'Katheryn Winnick'),
(11, 'Jennifer Aniston'),
(12, 'Matthew Perry'),
(13, 'Josh Radnor'),
(14, 'Jason Segel'),
(15, 'Johnny Galecki'),
(16, 'Jim Parsons'),
(17, 'Iain Armitage'),
(18, 'Zoe Perry'),
(19, 'Millie Bobby Brown'),
(20, 'David Harbour'),
(21, 'Charlie Hunnam'),
(22, 'Katey Sagal');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `characters`
--

CREATE TABLE `characters` (
  `character_id` int(11) NOT NULL,
  `character_name` varchar(255) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `actor_id` int(11) DEFAULT NULL,
  `series_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `characters`
--

INSERT INTO `characters` (`character_id`, `character_name`, `role_id`, `actor_id`, `series_id`) VALUES
(3, 'Harvey Specter', 1, 1, 3),
(4, 'Mike Ross', 1, 2, 3),
(5, 'Daenerys Targaryen', 1, 3, 4),
(6, 'Tyrion Lannister', 4, 4, 4),
(7, 'Walter White', 4, 5, 5),
(8, 'Jesse Pinkman', 4, 6, 5),
(9, 'Thomas Shelby', 1, 7, 6),
(10, 'Arthur Shelby', 4, 8, 6),
(11, 'Lagertha', 1, 10, 7),
(12, 'Ragnar Lothbrok', 1, 9, 7),
(13, 'Rachel Green', 4, 11, 8),
(14, 'Chandler Bing', 4, 12, 8),
(15, 'Ted Mosby', 4, 13, 9),
(16, 'Marshall Eriksen', 4, 14, 9),
(17, 'Sheldon Cooper', 4, 16, 10),
(18, 'Leonard Hofstadter', 4, 15, 10),
(19, 'Sheldon Cooper', 1, 17, 11),
(20, 'Mary Cooper', 4, 18, 11),
(21, 'Eleven', 1, 19, 12),
(22, 'Jim Hopper', 4, 20, 12),
(23, 'Jackson \\\'Jax\\\' Teller', 1, 21, 13),
(24, 'Gemma Teller Morrow', 4, 22, 13);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `directors`
--

CREATE TABLE `directors` (
  `director_id` int(11) NOT NULL,
  `director_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `directors`
--

INSERT INTO `directors` (`director_id`, `director_name`) VALUES
(1, 'Aaron Korsh'),
(2, 'David Nutter'),
(3, 'Michelle MacLaren'),
(4, 'Anthony Byrne'),
(5, 'Ciaran Donnelly'),
(6, 'Gary Halvorson'),
(7, 'Carter Bays'),
(8, 'Mark Cendrowski'),
(9, 'Alex Alerx Reid'),
(10, 'Matt Duffer'),
(11, 'Paris Barclay');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `favourite_series`
--

CREATE TABLE `favourite_series` (
  `favourite_series_id` int(11) NOT NULL,
  `user_id` int(11) DEFAULT NULL,
  `series_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `favourite_series`
--

INSERT INTO `favourite_series` (`favourite_series_id`, `user_id`, `series_id`) VALUES
(6, 3, 12),
(7, 3, 7),
(8, 3, 6),
(9, 4, 3),
(10, 4, 7),
(12, 6, 11),
(13, 6, 7),
(14, 6, 12),
(15, 7, 5),
(16, 7, 3),
(17, 7, 4),
(18, 7, 13),
(19, 8, 13);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `genres`
--

CREATE TABLE `genres` (
  `genre_id` int(11) NOT NULL,
  `genre_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `genres`
--

INSERT INTO `genres` (`genre_id`, `genre_name`) VALUES
(1, 'Action'),
(2, 'Comedy'),
(3, 'Adventure'),
(4, 'Science Fiction'),
(5, 'Romance'),
(6, 'Drama'),
(7, 'Horror'),
(8, 'Legal Drama'),
(9, 'Mystery'),
(10, 'Crime'),
(11, 'Thriller');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `reviews`
--

CREATE TABLE `reviews` (
  `review_id` int(11) NOT NULL,
  `text` text NOT NULL,
  `series_id` int(11) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `rating` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `reviews`
--

INSERT INTO `reviews` (`review_id`, `text`, `series_id`, `user_id`, `rating`) VALUES
(1, 'The best series ever! A classic.', 8, 3, 10),
(2, 'Loved it!', 3, 3, 10),
(3, 'Very funny!', 11, 3, 9),
(4, 'My favorite series! I finished it in 5 days!', 5, 3, 10),
(5, 'Not very good.Pretty boring!', 10, 3, 3),
(6, 'Never seen something better! Great experience.', 9, 3, 9),
(7, 'Good but a little too long!', 4, 3, 5),
(8, 'I enjoyed it very much!', 12, 3, 7),
(9, 'It\'s brong', 7, 3, 2),
(10, 'I found it very compelling!', 3, 4, 9),
(11, 'Wow!', 5, 4, 8),
(13, 'My favorite series!', 7, 4, 10),
(14, 'Among my favourites!', 6, 4, 9),
(15, 'Extraordinary!', 9, 4, 8),
(16, 'Amazing!', 13, 4, 8),
(18, 'My favorite series!', 11, 6, 10),
(19, 'Best series of all time!', 4, 6, 10),
(20, 'Masterpiece!', 3, 6, 9),
(21, 'Underrated', 10, 6, 10),
(22, 'Why Ragnar had to die??', 7, 6, 8),
(24, 'One of the best!', 12, 6, 9),
(25, 'Wow!', 8, 6, 9),
(26, 'My favorite!', 3, 7, 10),
(27, 'Woooooow!', 5, 7, 10),
(28, 'Too short!', 6, 7, 9),
(29, 'Why is it so underrated?', 7, 7, 9),
(30, 'So heartwhelming!', 10, 7, 10),
(31, 'Top!', 4, 7, 10),
(32, 'Impressed', 12, 7, 9),
(33, 'Absolutely my favorite', 13, 7, 10),
(34, 'okish', 3, 8, 5);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `roles`
--

CREATE TABLE `roles` (
  `role_id` int(11) NOT NULL,
  `role_name` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `roles`
--

INSERT INTO `roles` (`role_id`, `role_name`) VALUES
(1, 'Series Regular'),
(2, 'Recurring'),
(3, 'Guest Star'),
(4, 'Co-Star'),
(5, 'Background'),
(6, 'Cameo');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `series`
--

CREATE TABLE `series` (
  `series_id` int(11) NOT NULL,
  `series_name` varchar(255) NOT NULL,
  `start_year` year(4) DEFAULT NULL,
  `end_year` year(4) DEFAULT NULL,
  `isRunning` tinyint(1) DEFAULT NULL,
  `director_id` int(11) DEFAULT NULL,
  `img` varchar(100) DEFAULT NULL,
  `nb_reviews` int(11) DEFAULT NULL,
  `rating` float DEFAULT NULL,
  `details` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `series`
--

INSERT INTO `series` (`series_id`, `series_name`, `start_year`, `end_year`, `isRunning`, `director_id`, `img`, `nb_reviews`, `rating`, `details`) VALUES
(3, 'Suits', '2011', '2019', 0, 1, 'IMG-65a59c6959dd13.24449548.jpeg', 5, 8.6, 'On the run from a drug deal gone bad, brilliant college dropout Mike Ross finds himself working with Harvey Specter, one of New York City\'s best lawyers.'),
(4, 'Game of Thrones', '2011', '2019', 0, 2, 'IMG-65a59d95996f59.50217593.jpeg', 3, 8.75, 'Nine noble families fight for control over the lands of Westeros, while an ancient enemy returns after being dormant for a millennia.'),
(5, 'Breaking Bad', '2008', '2013', 0, 3, 'IMG-65a59ec1eb13a6.69662933.jpeg', 3, 9.5, 'A chemistry teacher diagnosed with inoperable lung cancer turns to manufacturing and selling methamphetamine with a former student in order to secure his family\'s future.'),
(6, 'Peaky Blinders', '2013', '2022', 0, 4, 'IMG-65a59fde71d074.21408230.jpeg', 2, 9, 'A gangster family epic set in 1900s England, centering on a gang who sew razor blades in the peaks of their caps, and their fierce boss Tommy Shelby.'),
(7, 'Vikings', '2013', '2020', 0, 5, 'IMG-65a5a0eb4cda52.45902019.jpeg', 4, 7.25, 'Vikings transports us to the brutal and mysterious world of Ragnar Lothbrok, a Viking warrior and farmer who yearns to explore--and raid--the distant shores across the ocean.'),
(8, 'Friends', '1994', '2004', 0, 6, 'IMG-65a5a20e257ae1.41941945.jpeg', 2, 9.5, 'Follows the personal and professional lives of six twenty to thirty year-old friends living in the Manhattan borough of New York City.'),
(9, 'How I Met Your Mother', '2005', '2014', 0, 7, 'IMG-65a5a37be88542.79374886.jpeg', 2, 8.5, 'A father recounts to his children - through a series of flashbacks - the journey he and his four best friends took leading up to him meeting their mother.'),
(10, 'The Big Bang Theory', '2007', '2019', 0, 8, 'IMG-65a5ab783dfdd8.14772124.jpeg', 3, 8.25, 'A woman who moves into an apartment across the hall from two brilliant but socially awkward physicists shows them how little they know about life outside of the laboratory.'),
(11, 'Young Sheldon', '2017', '2024', 1, 9, 'IMG-65a5ad24e66952.82227452.jpeg', 2, 9.5, 'Meet a child genius named Sheldon Cooper (already seen as an adult in Teoria Big Bang (2007)) and his family. Some unique challenges face Sheldon, who is socially impaired.'),
(12, 'Stranger Things', '2016', '2024', 1, 10, 'IMG-65a5aea22f9644.53785121.jpeg', 3, 8.5, 'When a young boy vanishes, a small town uncovers a mystery involving secret experiments, terrifying supernatural forces and one strange little girl.'),
(13, 'Sons of Anarchy', '2008', '2014', 0, 11, 'IMG-65a5afed2fe379.98708642.jpeg', 2, 9, 'A biker struggles to balance being a father and being involved in an outlaw motorcycle club.');

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `series_genres`
--

CREATE TABLE `series_genres` (
  `series_genre_id` int(11) NOT NULL,
  `genre_id` int(11) DEFAULT NULL,
  `series_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `series_genres`
--

INSERT INTO `series_genres` (`series_genre_id`, `genre_id`, `series_id`) VALUES
(3, 2, 3),
(4, 8, 3),
(5, 1, 4),
(6, 3, 4),
(7, 6, 4),
(8, 6, 5),
(9, 10, 5),
(10, 11, 5),
(11, 6, 6),
(12, 10, 6),
(13, 1, 7),
(14, 3, 7),
(15, 6, 7),
(16, 2, 8),
(17, 5, 8),
(18, 2, 9),
(19, 5, 9),
(20, 6, 9),
(21, 2, 10),
(22, 5, 10),
(23, 2, 11),
(24, 6, 12),
(25, 7, 12),
(26, 6, 13),
(27, 10, 13),
(28, 11, 13);

-- --------------------------------------------------------

--
-- Structură tabel pentru tabel `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Eliminarea datelor din tabel `users`
--

INSERT INTO `users` (`user_id`, `username`, `password`) VALUES
(2, 'muri', '$2y$10$7fAogty5UCzZBISUC4uicunxnpKveQMXocsj07c3moEfSTF28s9u2'),
(3, 'calinaborzan', '$2y$10$QtO1edeHZMFEKYUnRaH/kebNFxt/1AsA9o6k/xtLemHaPXDK6B6xK'),
(4, 'victor', '$2y$10$bzjkL0QNCu..vn0fC1HgGumB4rclyWY2FMzeCza9pS6z2sGYooASa'),
(6, 'felix', '$2y$10$sIi8vmYseGVM2ixsmbUmgOF2RDokVzkKLlCgCnFGO6vN9Wmes5Me.'),
(7, 'paul', '$2y$10$bcZkBamhyxDqPNpG3vP7w..QbQNPCR0UIXSWN.npwf7JqkkRJf1Ge'),
(8, 'vlad', '$2y$10$Xnz1t0mm2B3WFVswW7TEwuAH7wbctYuzXgR5oTZZBLil5IpiFf/6G');

--
-- Indexuri pentru tabele eliminate
--

--
-- Indexuri pentru tabele `actors`
--
ALTER TABLE `actors`
  ADD PRIMARY KEY (`actor_id`);

--
-- Indexuri pentru tabele `characters`
--
ALTER TABLE `characters`
  ADD PRIMARY KEY (`character_id`),
  ADD KEY `role_id` (`role_id`),
  ADD KEY `actor_id` (`actor_id`),
  ADD KEY `series_id` (`series_id`);

--
-- Indexuri pentru tabele `directors`
--
ALTER TABLE `directors`
  ADD PRIMARY KEY (`director_id`);

--
-- Indexuri pentru tabele `favourite_series`
--
ALTER TABLE `favourite_series`
  ADD PRIMARY KEY (`favourite_series_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `series_id` (`series_id`);

--
-- Indexuri pentru tabele `genres`
--
ALTER TABLE `genres`
  ADD PRIMARY KEY (`genre_id`);

--
-- Indexuri pentru tabele `reviews`
--
ALTER TABLE `reviews`
  ADD PRIMARY KEY (`review_id`),
  ADD KEY `series_id` (`series_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexuri pentru tabele `roles`
--
ALTER TABLE `roles`
  ADD PRIMARY KEY (`role_id`);

--
-- Indexuri pentru tabele `series`
--
ALTER TABLE `series`
  ADD PRIMARY KEY (`series_id`),
  ADD KEY `director_id` (`director_id`);

--
-- Indexuri pentru tabele `series_genres`
--
ALTER TABLE `series_genres`
  ADD PRIMARY KEY (`series_genre_id`),
  ADD KEY `genre_id` (`genre_id`),
  ADD KEY `series_id` (`series_id`);

--
-- Indexuri pentru tabele `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT pentru tabele eliminate
--

--
-- AUTO_INCREMENT pentru tabele `actors`
--
ALTER TABLE `actors`
  MODIFY `actor_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT pentru tabele `characters`
--
ALTER TABLE `characters`
  MODIFY `character_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT pentru tabele `directors`
--
ALTER TABLE `directors`
  MODIFY `director_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pentru tabele `favourite_series`
--
ALTER TABLE `favourite_series`
  MODIFY `favourite_series_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- AUTO_INCREMENT pentru tabele `genres`
--
ALTER TABLE `genres`
  MODIFY `genre_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT pentru tabele `reviews`
--
ALTER TABLE `reviews`
  MODIFY `review_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=35;

--
-- AUTO_INCREMENT pentru tabele `roles`
--
ALTER TABLE `roles`
  MODIFY `role_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT pentru tabele `series`
--
ALTER TABLE `series`
  MODIFY `series_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- AUTO_INCREMENT pentru tabele `series_genres`
--
ALTER TABLE `series_genres`
  MODIFY `series_genre_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT pentru tabele `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- Constrângeri pentru tabele eliminate
--

--
-- Constrângeri pentru tabele `characters`
--
ALTER TABLE `characters`
  ADD CONSTRAINT `characters_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `roles` (`role_id`),
  ADD CONSTRAINT `characters_ibfk_2` FOREIGN KEY (`actor_id`) REFERENCES `actors` (`actor_id`),
  ADD CONSTRAINT `characters_ibfk_3` FOREIGN KEY (`series_id`) REFERENCES `series` (`series_id`);

--
-- Constrângeri pentru tabele `favourite_series`
--
ALTER TABLE `favourite_series`
  ADD CONSTRAINT `favourite_series_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`),
  ADD CONSTRAINT `favourite_series_ibfk_2` FOREIGN KEY (`series_id`) REFERENCES `series` (`series_id`);

--
-- Constrângeri pentru tabele `reviews`
--
ALTER TABLE `reviews`
  ADD CONSTRAINT `reviews_ibfk_1` FOREIGN KEY (`series_id`) REFERENCES `series` (`series_id`),
  ADD CONSTRAINT `reviews_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);

--
-- Constrângeri pentru tabele `series`
--
ALTER TABLE `series`
  ADD CONSTRAINT `series_ibfk_1` FOREIGN KEY (`director_id`) REFERENCES `directors` (`director_id`);

--
-- Constrângeri pentru tabele `series_genres`
--
ALTER TABLE `series_genres`
  ADD CONSTRAINT `series_genres_ibfk_1` FOREIGN KEY (`genre_id`) REFERENCES `genres` (`genre_id`),
  ADD CONSTRAINT `series_genres_ibfk_2` FOREIGN KEY (`series_id`) REFERENCES `series` (`series_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
