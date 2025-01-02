
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
