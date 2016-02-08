ALTER TABLE `payments` ADD `amount_local` DECIMAL(11,2) NOT NULL DEFAULT '0' AFTER `type`;
ALTER TABLE `coordinators` ADD `skrill_acc` VARCHAR(255) NOT NULL AFTER `name`, ADD INDEX (`skrill_acc`) ;