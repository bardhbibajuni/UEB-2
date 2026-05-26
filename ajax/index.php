<?php
// Block direct access to ajax/ directory listing
http_response_code(403);
exit('Forbidden');
