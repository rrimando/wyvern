ALTER TABLE  `fuel_users` ADD  `entity` VARCHAR( 22 ) NOT NULL DEFAULT  'n/a';
ALTER TABLE  `wyvern_entity_values` CHANGE  `unique_id`  `unique_id` VARCHAR( 100 ) NOT NULL COMMENT  'This collates the Entity';
ALTER TABLE  `wyvern_entity_values` CHANGE  `id`  `id` INT( 50 ) NOT NULL AUTO_INCREMENT;
CREATE TABLE `wyvern_files` (
  `id` int NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `filename` varchar(255) NOT NULL,
  `title` varchar(100) NOT NULL
);
# ALTER TABLE  `wyvern_entities` CHANGE  `id`  `id` INT( 22 ) NOT NULL AUTO_INCREMENT;
# ALTER TABLE  `wyvern_entity_fields` CHANGE  `id`  `id` INT( 22 ) NOT NULL AUTO_INCREMENT;
# ALTER TABLE  `wyvern_entity_fields` CHANGE  `parent_id`  `parent_id` INT( 22 ) NOT NULL;
# ALTER TABLE  `wyvern_entity_values` CHANGE  `parent_entity_id`  `parent_entity_id` INT( 22 ) NOT NULL;
# ALTER TABLE  `wyvern_entity_values` CHANGE  `entity_field_id`  `entity_field_id` INT( 22 ) NOT NULL;
