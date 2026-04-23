SET FOREIGN_KEY_CHECKS = 0;

INSERT INTO `users` (`id`, `email`, `status`, `is_premium`, `country_code`, `last_active_at`, `created_at`) VALUES
    (1, 'hgreis@go0glelemail.com',     'active',    0, 'ES', '2022-03-01 12:33:45', '2022-03-01 12:33:45'),
    (2, 'matt5000@kaspecism.site',     'active',    0, 'ES', '2022-03-02 12:33:45', '2022-03-01 12:33:45'),
    (3, 'morasergio1@uioct.com',       'active',    0, 'GB', '2022-03-03 12:33:45', '2022-03-01 12:33:45'),
    (4, 'ren1033xxx@cua77-official.gq','active',    0, 'US', '2022-03-03 12:33:45', '2022-03-01 12:33:45'),
    (5, 'yogamag@uewodia.com',         'active',    1, 'ES', '2022-03-03 12:33:45', '2022-03-01 12:33:45'),
    (6, 'sttimers69@neeahoniy.com',    'active',    1, 'ES', '2022-03-03 12:33:45', '2022-03-01 12:33:45'),
    (7, 'jannatroshina@nkgursr.com',   'suspended', 1, 'LV', '2022-03-03 12:33:45', '2022-03-01 12:33:45');

INSERT INTO `devices` (`id`, `user_id`, `platform`, `label`, `created_at`) VALUES
    (1, 1, 'android', 'test device',     '2022-03-03 12:33:45'),
    (2, 2, 'windows', 'my first device', '2022-03-03 12:33:45'),
    (3, 3, 'windows', 'test app',        '2022-03-03 12:33:45'),
    (4, 4, 'android', 'moms phone',      '2022-03-03 12:33:45'),
    (5, 5, 'android', 'italy',           '2022-03-03 12:33:45'),
    (6, 5, 'windows', 'server',          '2022-03-03 12:33:45'),
    (7, 6, 'ios',     'new phone',       '2022-03-03 12:33:45'),
    (8, 6, 'android', 'old phone',       '2022-03-03 12:33:45'),
    (9, 6, 'windows', 'LAPTOP',          '2022-03-03 12:33:45');

SET FOREIGN_KEY_CHECKS = 1;
