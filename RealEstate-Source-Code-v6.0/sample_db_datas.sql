--
-- Please run commands in README.md file before run this.
--

use publ_realty;

--
-- Sample `cities` data
--

INSERT INTO `cities` VALUES 
(1,'Istanbul','f269dd0b-a6b4-485b-bfc2-461e904203d4.jpg',0,'2022-03-24 18:26:02','2022-03-24 18:26:02'),
(2,'London','d75ade94-6e48-4def-8a84-65681cc38528.jpg',0,'2022-03-24 18:26:37','2022-03-24 18:26:37'),
(3,'Berlin','b8ed221a-c358-4d6a-ba1c-f704737a8584.jpg',0,'2022-03-24 18:26:57','2022-03-24 18:26:57'),
(4,'Dubai','7d4def7d-57b1-44f9-a9c3-a2f0e29e75a4.jpg',0,'2022-03-24 18:27:16','2022-03-24 18:27:16'),
(5,'Paris','10cbf077-5337-47ba-867a-e48fad8dc0c9.jpg',0,'2022-03-24 18:27:34','2022-03-24 18:27:34');

--
-- Sample `news_categories` data
--

INSERT INTO `news_categories` VALUES 
(1,'Real Estate','2022-03-24 18:50:25','2022-03-24 18:50:25');

--
-- Sample `news` data
--

INSERT INTO `news` VALUES 
(1,1,'Lorem ipsum dolor sit amet, consectetur adipiscing elit','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p><p>Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>','0229ba6b-17fb-49c6-b9dc-d4faba43d380.jpg','2022-03-24 18:51:46','2022-03-24 18:51:46'),
(2,1,'Lorem ipsum dolor sit amet, consectetur adipiscing elit','<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.</p><p><span style=\"font-size: 1rem;\">Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</span></p>','34395236-bef1-4bb0-937f-49c6f4f2b941.jpg','2022-03-24 18:52:42','2022-03-24 18:52:42');

--
-- Sample `property_categories` data
--

INSERT INTO `property_categories` VALUES 
(1,'Apartment','2022-03-24 18:28:54','2022-03-24 18:28:54');

--
-- Sample `properties` data
--

INSERT INTO `properties` VALUES 
(1,1,1,1,1,1,'Hilton House','<p><span style=\"text-align: justify;\">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</span></p><p><span style=\"text-align: justify;\">Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</span></p>','71e473b7-63bd-4cfc-b145-458953401c43.jpg,ab8ac0d0-8aa5-4b91-b137-a4134a683b97.jpg,ed5ba3bb-8eda-4032-8b57-fe27cb4d37a5.jpg',120,2,2,3,1,'Air conditioning, Central Heating, City views, Telephone, Family Villa, Internet',1200000.00,'$','142, Levent, Istanbul',40.990000,29.020000,'2022-03-24 18:34:44','2022-03-24 18:34:44',1),
(2,1,1,1,2,1,'Big House','<p><span style=\"text-align: justify;\">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</span></p><p><span style=\"text-align: justify;\">Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</span></p>','198384a5-47b4-4350-9e69-efd236126b07.jpg,cd2f3674-d62f-4063-ba3f-8b07fd5aeb22.jpg,3b574173-d057-419a-a64f-342f82098040.jpg,1a083295-5b4b-48d9-ae29-6d115fc6bd72.jpg',520,3,3,3,2,'Air conditioning, Central Heating, City views, Telephone, Family Villa, Internet',750000.00,'£','9484 Albert Road, London',51.560000,0.000000,'2022-03-24 18:43:27','2022-03-24 18:43:27',1),
(3,2,1,1,1,1,'Bosphorus View','<p><span style=\"text-align: justify;\">Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.</span></p><p><span style=\"text-align: justify;\">Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt.</span></p>','f4929390-497c-48b2-b092-0985584cf42f.jpg,c80ac68b-3ed8-4302-8bfa-85f212867936.jpg,9315a206-24ec-4cf6-97ca-c6b1dbcfdbe3.jpg,3d1b7bd3-16fc-4cce-945f-2d2c69e58b56.jpg',400,2,3,2,1,'Bosphorus views, Telephone, Family Villa, Internet',24000.00,'₺','Rihtim Caddesi, 34710 Kadıköy',41.100000,29.050000,'2022-03-24 18:47:53','2022-03-24 18:48:36',1);

--
-- Update `app_settings` data
--

UPDATE `app_settings` SET header_images = '6dabb739-5bdb-42ed-b8b0-c4af91174f94.jpg,613db561-ef7c-4835-9238-74c04b8b569e.jpg,675ce45c-8bf4-45e9-858f-d2a28fa5c42b.jpg' WHERE 1;;