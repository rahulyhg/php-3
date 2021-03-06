<?php

// Feed Settings/
if (empty(Settings::getInstance()->SETTINGS['map_latitude']))  Settings::getInstance()->SETTINGS['map_latitude']   = 49.2635880;
if (empty(Settings::getInstance()->SETTINGS['map_longitude'])) Settings::getInstance()->SETTINGS['map_longitude']  = -123.1385650;
Settings::getInstance()->SETTINGS['map_state'] = 'BC';

// This feed does not allow price change history
Settings::getInstance()->MODULES['REW_IDX_HISTORY_PRICE'] = false;

// This feed does not allow status change history
Settings::getInstance()->MODULES['REW_IDX_HISTORY_STATUS'] = false;

// Canadian feed
Settings::getInstance()->LANG = 'en-CA';