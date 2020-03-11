<?php
 session_start();
 session_destroy();
 echo("<script>alert('You have been logged out!')</script>");
 echo("<script>window.location = 'https://pascal.mscsnet.mu.edu/quiz';</script>");
?>