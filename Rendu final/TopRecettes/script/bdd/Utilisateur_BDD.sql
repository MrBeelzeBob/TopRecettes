
-- Cedric Dos Reis
-- TopRecettes - TPI 2015
-- Utilisateur de la base de données

GRANT USAGE ON *.* TO 'User_TopRecettes'@'localhost' IDENTIFIED BY PASSWORD '*9394151303A2D383B39D4DA8347660F90D11A1A3';

GRANT SELECT, INSERT, UPDATE, DELETE ON `toprecettes`.* TO 'User_TopRecettes'@'localhost';