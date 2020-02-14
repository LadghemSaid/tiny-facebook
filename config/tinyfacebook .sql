-- phpMyAdmin SQL Dump
-- version 4.0.10deb1
-- http://www.phpmyadmin.net
--
-- Client: 127.0.0.1
-- Généré le: Dim 16 Décembre 2018 à 02:20
-- Version du serveur: 5.5.57-0ubuntu0.14.04.1
-- Version de PHP: 5.5.9-1ubuntu4.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Base de données: `tinyfacebook`
--

-- --------------------------------------------------------

--
-- Structure de la table `commentaire`
--

CREATE TABLE IF NOT EXISTS `commentaire` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idComment` int(11) NOT NULL,
  `content` varchar(255) NOT NULL,
  `datecom` datetime NOT NULL,
  `idAuteur` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=6 ;

--
-- Contenu de la table `commentaire`
--

INSERT INTO `commentaire` (`id`, `idComment`, `content`, `datecom`, `idAuteur`) VALUES
(1, 7, 'Un commentaire d''adri', '2018-12-10 21:46:11', 4),
(4, 17, 'Un com', '2018-12-11 08:32:07', 2),
(5, 3, 'Haha', '2018-12-12 20:00:30', 2);

-- --------------------------------------------------------

--
-- Structure de la table `ecrit`
--

CREATE TABLE IF NOT EXISTS `ecrit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `titre` varchar(255) NOT NULL,
  `contenu` text,
  `dateEcrit` datetime NOT NULL,
  `image` varchar(255) DEFAULT NULL,
  `idAuteurPost` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `id` (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=24 ;

--
-- Contenu de la table `ecrit`
--

INSERT INTO `ecrit` (`id`, `titre`, `contenu`, `dateEcrit`, `image`, `idAuteurPost`) VALUES
(17, '', 'Ys un post ', '2018-12-11 08:31:57', '0a1da753342713.5930a6167fb07.jpg', 2),
(7, '', '1er post adri', '2018-12-10 21:45:54', '', 4),
(3, '', '1ER post de Gille', '2018-12-10 10:06:04', '', 1),
(18, '', 'Inspirant', '2018-12-14 22:16:45', 'I-feel-like-Im-in-Blade-Runner-now.jpg', 2),
(10, '', 'Un second post d''Adri', '2018-12-10 21:49:55', '', 4),
(19, '', 'Ça aussi', '2018-12-14 22:17:09', 'This-looks-like-its-from-Inception-but-its-a-real-image-from-Macau.jpg', 2),
(20, '', 'Un nouveau post de nico', '2018-12-15 23:32:58', 'Desert.jpg', 8),
(23, '', 'Une video ? ', '2018-12-16 00:51:44', 'anim-5.mp4', 8);

-- --------------------------------------------------------

--
-- Structure de la table `friends`
--

CREATE TABLE IF NOT EXISTS `friends` (
  `iduser` int(255) NOT NULL,
  `idfriend` int(255) NOT NULL,
  `isvalidate` tinyint(1) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Contenu de la table `friends`
--

INSERT INTO `friends` (`iduser`, `idfriend`, `isvalidate`) VALUES
(4, 2, 1),
(2, 4, 1),
(4, 1, 1),
(1, 4, 1),
(1, 2, 1),
(2, 1, 1),
(8, 2, 1),
(8, 1, NULL),
(8, 4, NULL),
(8, 3, NULL),
(2, 8, 1);

-- --------------------------------------------------------

--
-- Structure de la table `info_user`
--

CREATE TABLE IF NOT EXISTS `info_user` (
  `id` int(11) NOT NULL,
  `nom` varchar(255) NOT NULL,
  `prenom` varchar(255) NOT NULL,
  `age` int(11) NOT NULL,
  `description` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL,
  `genre` varchar(255) NOT NULL,
  `music_style` varchar(255) DEFAULT NULL,
  `favorite_music_style` varchar(255) DEFAULT NULL,
  `food` varchar(255) DEFAULT NULL,
  `relationship` varchar(255) DEFAULT NULL,
  `interest` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `info_user`
--

INSERT INTO `info_user` (`id`, `nom`, `prenom`, `age`, `description`, `status`, `genre`, `music_style`, `favorite_music_style`, `food`, `relationship`, `interest`) VALUES
(2, 'Said', 'Ladghem', 24, 'Je m''appelle GIlles', 'Salarie', 'homme', 'pop,rock,rap,rnb,metal', 'Metal', 'Végétarien', 'Célibataire', 'Jeux video,Netflix,Les films de Miyazaki,Internet,La 3D'),
(4, 'Lecouty', 'Adrien', 18, 'Je m''appelle Adrien', 'Etudiant', 'homme', 'rap,rnb', 'RnB', 'Carnivore', 'En couple', 'Netflix,Les films de Miyazaki'),
(1, 'Gilles', 'Doe', 60, 'Je m''appelle GIlles', 'Salarie', 'homme', 'rnb,metal', 'Pop', 'Végétarien', 'Compliqué', 'Jeux video,Netflix,Les films de Miyazaki,MMI'),
(8, 'Nicolas', 'Brouillard', 20, 'Je fais de la muscu', 'Etudiant', 'homme', 'pop,rock,metal', 'Metal', 'Carnivore', 'Célibataire', 'Jeux video,Netflix,Les films de Miyazaki,La muscu');

-- --------------------------------------------------------

--
-- Structure de la table `rating_info`
--

CREATE TABLE IF NOT EXISTS `rating_info` (
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL,
  `rating_action` varchar(30) NOT NULL,
  UNIQUE KEY `UC_rating_info` (`user_id`,`post_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `rating_info`
--

INSERT INTO `rating_info` (`user_id`, `post_id`, `rating_action`) VALUES
(2, 3, 'like'),
(2, 17, 'dislike'),
(4, 7, 'like'),
(4, 9, 'like');

-- --------------------------------------------------------

--
-- Structure de la table `rating_info_commentaire`
--

CREATE TABLE IF NOT EXISTS `rating_info_commentaire` (
  `id_post_p` int(11) NOT NULL,
  `id_commentaire` int(11) NOT NULL,
  `id_user_like` int(11) NOT NULL,
  `action` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Contenu de la table `rating_info_commentaire`
--

INSERT INTO `rating_info_commentaire` (`id_post_p`, `id_commentaire`, `id_user_like`, `action`) VALUES
(7, 1, 4, 'like'),
(17, 4, 2, 'like'),
(3, 5, 2, 'like');

-- --------------------------------------------------------

--
-- Structure de la table `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` varchar(100) NOT NULL,
  `mdp` varchar(255) NOT NULL,
  `email` varchar(255) DEFAULT NULL,
  `remember` varchar(255) DEFAULT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `lastco` datetime NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `login` (`login`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=14 ;

--
-- Contenu de la table `user`
--

INSERT INTO `user` (`id`, `login`, `mdp`, `email`, `remember`, `avatar`, `lastco`) VALUES
(1, 'gilles', '*A4B6157319038724E3560894F7F932C8886EBFCF', 'gilles@toto.fr', NULL, 'user404.png', '2018-12-15 23:40:22'),
(2, 'Said', '*2CE34926DEDE731C32296F5E6B87D6C9A5C287D7', NULL, '5d0bd81ac5c61bf93b7e141fbdfde944465f17850abc2beab88eca38707dc6e5', 'Anyone-else-hyped-for-this-game.jpg', '2018-12-16 02:02:46'),
(3, 'Lena', '*A4B6157319038724E3560894F7F932C8886EBFCF', NULL, NULL, 'user404.png', '0000-00-00 00:00:00'),
(4, 'Adri', '*2CE34926DEDE731C32296F5E6B87D6C9A5C287D7', NULL, NULL, 'Hydrangeas.jpg', '2018-12-15 23:35:00'),
(5, 'aze', '*2CE34926DEDE731C32296F5E6B87D6C9A5C287D7', 'aze@gmail.com', NULL, 'user404.png', '0000-00-00 00:00:00'),
(8, 'nico', '*2CE34926DEDE731C32296F5E6B87D6C9A5C287D7', 'nico@sd.Fr', NULL, 'user404.png', '2018-12-16 01:37:02'),
(9, 'toto111', '*B5535635B0B281264C1C2D3F74481B6451AC8FE2', 'zetzdf@sdfsd.gt', NULL, 'user404.png', '0000-00-00 00:00:00'),
(10, 'said2', '*2CE34926DEDE731C32296F5E6B87D6C9A5C287D7', 'aze@gmail.fom', NULL, 'user404.png', '0000-00-00 00:00:00'),
(11, 'Titi', '*2CE34926DEDE731C32296F5E6B87D6C9A5C287D7', 'aze@gmail.com', NULL, 'user404.png', '0000-00-00 00:00:00'),
(12, 'totor', '*2CE34926DEDE731C32296F5E6B87D6C9A5C287D7', 'aze@gmail.com', NULL, 'user404.png', '0000-00-00 00:00:00'),
(13, 'eza', '*2CE34926DEDE731C32296F5E6B87D6C9A5C287D7', 'aze@gmail.com', NULL, 'user404.png', '0000-00-00 00:00:00');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
