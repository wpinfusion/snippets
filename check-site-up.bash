#!/bin/bash                                                                                                                                            

# Bash snippet to check if a site is up, and if not notify us via Pushover

status=`curl -s -o /dev/null -w "%{http_code}" https://.nl/`                                                                                
                                                                                                                                                       
if [[ $status == 200 ]]                                                                                                                                
then                                                                                                                                                   
    exit                                                                                                                                               
else                                                                                                                                                   
    curl -s --form-string "token=" --form-string "user=" --form-string "message=SERVER DOWN: " https://api.pushover.net/1/messages.json                                                                                             
fi
