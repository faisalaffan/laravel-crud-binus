-- Database export via SQLPro (https://www.sqlprostudio.com/allapps.html)
-- Exported by faisalaffan at 26-01-2023 13:27.
-- WARNING: This file may contain descructive statements such as DROPs.
-- Please ensure that you are running the script at the proper location.


-- BEGIN TABLE user
DROP TABLE IF EXISTS user;
CREATE TABLE `user` (
  `id_user` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `nama_lengkap` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `password` varchar(100) DEFAULT NULL,
  `rbac` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_user`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=latin1;

-- Inserting 2 rows into user
-- Insert batch #1
INSERT INTO user (id_user, nama_lengkap, email, password, rbac) VALUES
(6, 'Muhammad Faisal Affan', 'faisallionel@gmail.com', '$2y$10$Vn7GvAHF6SviLu8NQdskou3ssdhHrBq.1A4UxE63M4fXX23WXmsJK', 'asd'),

-- END TABLE user

