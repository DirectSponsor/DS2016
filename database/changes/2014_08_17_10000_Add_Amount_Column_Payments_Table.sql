ALTER TABLE `payments` ADD `amount_local` DECIMAL(11,2) NOT NULL DEFAULT '0' AFTER `type`;
