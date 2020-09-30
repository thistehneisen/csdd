CREATE TABLE `vehicle_numbers` (
  `id` int(11) NOT NULL,
  `vnz` varchar(6) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `data` longtext,
  `response` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

ALTER TABLE `vehicle_numbers`
  ADD PRIMARY KEY (`id`);

ALTER TABLE `vehicle_numbers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;