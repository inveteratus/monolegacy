
INSERT INTO cities (cityname, citydesc, cityminlevel)
    VALUES
        ('Tokyo', 'Japan', 1),
        ('Istanbul', 'Turkey', 1),
        ('Paris', 'France', 1),
        ('Bangkok', 'Thailand', 2),
        ('Seoul', 'South Korea', 2),
        ('London', 'United Kingdom', 3),
        ('Kuala Lumpur', 'Malaysia', 5),
        ('New York City', 'United States', 8),
        ('Hong Kong', 'Hong Kong', 12),
        ('Madrid', 'Spain', 20),
        ('Singapore', 'Singapore', 31),
        ('Rome', 'Italy', 50);

INSERT INTO houses (hNAME, hPRICE, hWILL)
    VALUES
        ('Cottage', 5000, 100),
        ('Bungalow', 13500, 150),
        ('Ranch', 38000, 200),
        ('Chalet', 108250, 300),
        ('Villa', 310000, 400),
        ('Townhouse', 890000, 600),
        ('Condominium', 2555750, 850),
        ('Apartment', 7341250, 1200),
        ('Penthouse', 21089000, 1700),
        ('Mansion', 60583750, 2450),
        ('Castle', 174045250, 3500),
        ('Palace', 500000000, 5000);

INSERT INTO settings (conf_name, conf_value)
    VALUES
        ('validate_period', 15),
        ('validate_on', 0),
        ('regcap_on', 0),
        ('hospital_count', 0),
        ('jail_count', 0),
        ('sendcrys_on', 1),
        ('sendbank_on', 1),
        ('ct_refillprice', 12),
        ('ct_iqpercrys', 5),
        ('ct_moneypercrys', 5),
        ('staff_pad', ''),
        ('willp_item', 0),
        ('jquery_location', 'js/jquery-1.7.1.min.js'),
        ('game_name', 'Monolegacy'),
        ('game_description', 'Description'),
        ('game_owner', 'Owner');

INSERT INTO users (username, password, user_level, gender, signedup, email, lastip_signup)
    VALUES
        ('Administrator', '$2y$10$9wHM3pLVV9nUfa1OUOXEs.pA6LjgZ4SMFimkGsdtMNWxod0s7MDkm', 2, 'Male', UNIX_TIMESTAMP(), 'admin@example.com', '0.0.0.0'),
        ('User', '$2y$10$HiZpEOoSgSDkGSp9m8O1Ce8udXiCm51O9r3e/yqOzw3F2ISYzXil6', 1, 'Female', UNIX_TIMESTAMP(), 'user@example.com', '0.0.0.0');

INSERT INTO userstats (userid, strength, agility, guard, labour, IQ)
    VALUES
        (1, 10, 10, 10, 10, 10),
        (2, 10, 10, 10, 10, 10);

INSERT INTO crimegroups (cgID, cgNAME, cgORDER)
    VALUES
        (1, 'Easy crimes', 1);

INSERT INTO crimes (crimeID, crimeNAME, crimeBRAVE, crimePERCFORM, crimeSUCCESSMUNY, crimeSUCCESSCRYS, crimeSUCCESSITEM, crimeGROUP, crimeITEXT, crimeSTEXT, crimeFTEXT, crimeJTEXT, crimeJAILTIME, crimeJREASON, crimeXP)
    VALUES
        (1, 'Pocket Panic', 1, '50 + crime_experience / 10', 50, 0, 0, 1, 'The marketplace buzzes with life. A distracted tourist pauses to admire a souvenir stall, their wallet peeking from a loose pocket. This is your chance.', 'You slip the wallet out unnoticed, a cool grin spreading as you merge back into the crowd. Easy money!', 'Your fingers fumble, and the tourist whirls around with a yell. Nearby vendors close in. Time to run!', 'A local policeman sees your poor pick-pocketing attempt and swiftly nabs you.', 2, 'Caught pickpocketing', 10),
        (2, 'Tag & Dash', 1, '45 + crime_experience / 11', 0, 0, 0, 1, 'The wall looms before you, pristine and begging for your artistic touch. The night is quiet, but you can\'t shake the feeling you\'re being watched.', 'Your tag blazes brightly under the streetlights as you vanish into the shadows. A masterpiece in the making!', 'The screech of a whistle cuts through the air as security rounds the corner. Your spray can clatters to the ground. Busted!', 'Being caught be security sadly yields some time behind bars.', 4, 'Spraying walls', 12),
        (3, 'Electric Swipe', 1, '40 + crime_experience / 12', 75, 0, 0, 1, 'The scooter stands alone at the curb, its digital lock blinking mockingly. Time to show it who\'s boss.', 'The lock clicks open, and you ride off smoothly. Transportation secured with a side of victory!', 'The lock resists your every trick. A passerby eyes you suspiciously, and you decide to walk away before trouble brews.', 'Unfortunately, the passerby informed the local police who quickly detain you.', 6, 'Swiping scooters', 14),
        (4, 'Counterfeit Delivery', 1, '35 + crime_experience / 13', 60, 0, 0, 1, 'Your makeshift stall is set up, fake goods neatly displayed. A potential buyer approaches, eyeing your wares with curiosity.', 'The buyer walks away convinced they scored a deal. The cash in your pocket tells a different story.', 'The buyer squints at the product, then at you. '"This isn\'t real,"' they mutter loudly, drawing unwanted attention. Time to bolt!', 'Looks like the security cameras were on; you get a surprise visit from the police.', 8, 'Reselling dodgy goods', 16),
        (5, 'The Wallet Switch', 1, '30 + crime_experience / 14', 50, 0, 0, 1, 'The bar\'s dim lighting makes it the perfect spot. Your target chats away, oblivious to the wallet resting on the counter. Timing is everything.', 'The decoy is in place, and the wallet is yours. You slip out of the bar, your prize safely tucked away.', 'Your target notices the switch, and their furious outburst turns heads. Looks like you\'re paying for tonight\'s drinks in more ways than one.', 'The barman, being an ex copper, reports you.', 10, 'Caught switching wallets', 18);

INSERT INTO `jobs` (id, name)
    VALUES
        (1,'Construction'),
        (2,'Technology'),
        (3,'Healthcare'),
        (4,'Military'),
        (5,'Entertainment'),
        (6,'Science');

INSERT INTO `jobranks`
    VALUES
        (1,'Helper','An entry-level position for learning basic skills and assisting senior workers.',1,25000,250,250,300,500,0,15,10,20,30,0),
        (2,'Skilled Worker','A skilled worker responsible for specific tasks on construction projects.',1,40000,1000,750,1200,1500,0,25,15,30,40,0),
        (3,'Foreman','Supervises and coordinates the efforts of construction workers on site.',1,60000,5000,2500,4000,6000,1000,40,20,50,50,10),
        (4,'Project Manager','Oversees entire construction projects, ensuring they are completed on time and within budget.',1,90000,25000,15000,20000,30000,5000,60,30,70,60,20),
        (5,'Contract Manager','Manages contracts and negotiations for large-scale construction projects.',1,150000,75000,50000,60000,90000,20000,80,40,90,80,30),
        (6,'Real Estate Developer','Develops real estate projects from concept to completion.',1,250000,150000,100000,120000,150000,50000,100,50,120,100,50),
        (7,'IT Assistant','Assists IT teams with basic tasks while gaining hands-on experience.',2,30000,0,0,0,250,500,0,0,0,10,20),
        (8,'Junior Developer','Writes and tests code for software applications under supervision.',2,50000,0,0,0,500,1000,0,0,0,20,40),
        (9,'Software Engineer','Designs and develops software solutions to complex problems.',2,80000,0,0,500,1500,5000,0,0,10,30,60),
        (10,'Team Lead','Leads development teams and ensures software projects are successful.',2,120000,0,0,1000,5000,20000,0,0,20,50,100),
        (11,'Tech Manager','Oversees multiple development teams and aligns projects with company goals.',2,180000,0,0,5000,20000,75000,0,0,30,70,150),
        (12,'CTO','Sets the technological vision and strategy for the entire company.',2,300000,0,0,15000,60000,150000,0,0,50,100,200),
        (13,'Assistant','Supports healthcare professionals in patient care and administrative tasks.',3,35000,250,250,0,500,750,10,10,0,15,20),
        (14,'Nurse','Provides direct patient care and assists doctors in medical procedures.',3,55000,500,500,0,1000,2000,20,20,0,25,40),
        (15,'Physician Assistant','Works closely with doctors to diagnose and treat patients.',3,80000,750,750,0,3000,8000,30,30,0,40,60),
        (16,'Doctor','Diagnoses illnesses and provides comprehensive treatment plans.',3,150000,2000,1000,0,10000,30000,40,40,0,70,120),
        (17,'Surgeon','Performs complex surgical procedures to treat injuries and diseases.',3,250000,5000,2500,0,40000,100000,50,50,0,100,200),
        (18,'Healthcare Administrator','Leads healthcare organizations and sets medical policies.',3,400000,10000,5000,0,100000,200000,60,60,0,150,300),
        (19,'Recruit','Learns the basics of military service and discipline.',4,20000,500,500,500,500,0,20,20,20,20,0),
        (20,'Private','Performs basic military duties as a junior enlisted soldier.',4,35000,1000,1000,1000,1500,0,30,30,30,40,0),
        (21,'Sergeant','Leads small units and provides tactical guidance in operations.',4,60000,5000,3000,4000,6000,1000,40,40,50,60,10),
        (22,'Lieutenant','Commands troops and develops operational strategies.',4,100000,20000,10000,15000,25000,5000,60,50,70,80,20),
        (23,'Colonel','Oversees large units and coordinates high-level military plans.',4,150000,50000,25000,40000,60000,20000,80,70,90,100,30),
        (24,'General','Directs entire military campaigns and manages national defense.',4,300000,100000,50000,80000,120000,50000,100,100,120,150,50),
        (25,'Street Performer','Performs for the public on streets and other informal venues.',5,20000,250,500,0,250,0,10,20,0,10,0),
        (26,'Local Artist','Creates and performs art in small, local settings.',5,35000,500,1000,0,500,250,20,30,0,20,10),
        (27,'Entertainer','Entertains professionally in various media and venues.',5,70000,1000,5000,0,1000,1000,30,50,0,30,20),
        (28,'Celebrity','Achieves fame and recognition in the entertainment industry.',5,150000,5000,20000,0,3000,5000,40,70,0,50,30),
        (29,'Superstar','Reaches international stardom and commands high pay.',5,300000,20000,50000,0,6000,20000,50,100,0,70,50),
        (30,'Legend','Becomes an iconic figure with a lasting legacy.',5,500000,50000,100000,0,15000,50000,60,150,0,100,100),
        (31,'Lab Assistant','Assists senior scientists with experiments and lab work.',6,30000,0,250,250,500,500,0,10,10,20,20),
        (32,'Researcher','Conducts basic research and publishes findings.',6,50000,0,500,500,1000,2000,0,20,20,30,40),
        (33,'Senior Researcher','Leads research projects and develops new scientific theories.',6,80000,0,1000,1000,3000,8000,0,30,30,40,60),
        (34,'Project Lead','Manages teams of researchers and coordinates major projects.',6,120000,0,3000,3000,10000,30000,0,40,40,60,100),
        (35,'Principal Investigator','Sets research agendas and secures funding for projects.',6,200000,0,10000,10000,30000,100000,0,50,50,80,150),
        (36,'Nobel Laureate','Achieves global recognition for groundbreaking discoveries.',6,400000,0,20000,20000,60000,200000,0,60,60,100,300);
