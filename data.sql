
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

INSERT INTO users (username, userpass, user_level, gender, signedup, email, lastip_signup, pass_salt)
    VALUES
        ('Administrator', '42f4ec6d429c5800fe2cf2bc21cd1d64', 2, 'Male', UNIX_TIMESTAMP(), 'admin@example.com', '0.0.0.0', 'deadbeef'),
        ('User', '42f4ec6d429c5800fe2cf2bc21cd1d64', 1, 'Female', UNIX_TIMESTAMP(), 'user@example.com', '0.0.0.0', 'deadbeef');

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
