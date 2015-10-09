<?php

echo "<h1>Hello!</h1>";

//echo $this->tag->linkTo("signup", "Sign Up Here!");
//echo $this->tag->linkTo("signup/signup", "Sign Up Here!");
echo Phalcon\Tag::linkTo("signup/", "Sign Up Here!");

