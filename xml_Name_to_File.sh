#!/bin/bash
cd /var/www/html/Eventos/xml
rm *.xml
curl -s http://192.168.3.16/xml/templates_cdi/ | awk -F 'href="|">' '/<tr><td valign="top"><img src="\/icons\/text.gif" alt="\[TXT\]"><\/td><td><a href=/{print $4}' | xargs -I {} touch {}

