<?php

// How to Set Cookies
setcookie('key','value', time() + 10);

// How to Update a Cookie
setcookie('key','value[updated]',time() + 3600);

// How to Delete a Cookie
setcookie('key','',time() - 1);