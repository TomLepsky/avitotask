
SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";

CREATE TABLE `avito_orders` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `destination` varchar(255) DEFAULT NULL,
  `departure` varchar(255) NOT NULL,
  `price` float DEFAULT NULL,
  `destination_date` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



INSERT INTO `avito_orders` (`id`, `name`, `destination`, `departure`, `price`, `destination_date`) VALUES
(7, 'order1', 'destination11', 'dept1', 562, '2020-09-22 03:21:11'),
(8, 'order2', 'destination2', 'dept2', 36, '2020-09-22 17:14:31'),
(12, 'order3', 'destination3', 'dept3', 207, '2020-09-23 21:01:11');



CREATE TABLE `apilimiter` (
  `ipv4` varchar(15) NOT NULL,
  `timelimit` int(11) NOT NULL,
  `connections` int(11) DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;


ALTER TABLE `avito_orders`
  ADD PRIMARY KEY (`id`);


ALTER TABLE `apilimiter`
  ADD PRIMARY KEY (`ipv4`);
  

ALTER TABLE `avito_orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

