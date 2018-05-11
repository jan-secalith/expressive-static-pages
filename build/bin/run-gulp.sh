#!/bin/bash
cd /var/www/build
gulp default && gulp css_bt_copy_fonts && gulp clean_tmp